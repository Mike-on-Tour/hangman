<?php
/*
*
* @package Hangman v0.2.4
* @author Mike-on-Tour
* @copyright (c) 2021 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace mot\hangman\controller;

use phpbb\language\language_file_loader;

class main
{
	/* @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var ContainerBuilder */
	protected $phpbb_container;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $php_ext;

	protected $table_prefix;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\extension\manager $phpbb_extension_manager,
								\phpbb\controller\helper $helper, \phpbb\language\language $language, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext, $table_prefix)
	{
		define ('HANGMAN_SCORE_TABLE', $table_prefix . 'mot_hangman_score');
		define ('HANGMAN_WORDS_TABLE', $table_prefix . 'mot_hangman_words');
		global $phpbb_container;

		$this->config = $config;
		$this->db = $db;
		$this->phpbb_extension_manager 	= $phpbb_extension_manager;
		$this->helper = $helper;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_container = $phpbb_container;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function display()
	{
		$pagination = $this->phpbb_container->get('pagination');

		//If user is a bot.... redirect to the index.
		if ($this->user->data['is_bot'])
		{
			redirect(append_sid("{$this->root_path}index." . $this->php_ext));
		}

		// Check if the user ist logged in.
		if (!$this->user->data['is_registered'])
		{
			// Not logged in ? Redirect to the loginbox.
			login_box('', $this->language->lang('NO_AUTH_OPERATION'));
		}

		$this->game_action = $this->helper->route('mot_hangman_main_controller', ['tab' => '1']);
		$this->word_action = $this->helper->route('mot_hangman_main_controller', ['tab' => '2']);
		$this->rank_action = $this->helper->route('mot_hangman_main_controller', ['tab' => '3']);

		// Get the possible letters from the default language file
		$lang_arr = array();
		$default_lang = new language_file_loader($this->root_path, $this->php_ext);
		$default_lang->set_extension_manager($this->phpbb_extension_manager);
		$default_lang->load_extension('mot/hangman', 'common', array($this->config['default_lang'], 'en'), $lang_arr);
		$letters = explode(',', $lang_arr['HANGMAN_LETTERS']);
		$lc_letters = mb_strtolower($lang_arr['HANGMAN_LETTERS'], 'UTF-8');

		$tab = $this->request->variable('tab', 0);
		switch ($tab)
		{
			case 0:
			case 1:
			default:
				add_form_key('hangman_game_frm');
				$this->u_action = $this->helper->route('mot_hangman_main_controller', ['tab' => '1']);

				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key('hangman_game_frm'))
					{
						trigger_error($this->language->lang('FORM_INVALID') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
					}

					$game_points = $this->request->variable('score', 0);
					$word_id = $this->request->variable('word_id', 0);

					// Delete the used quote from database
					$sql_in = array($word_id);
					$sql = 'DELETE FROM ' . HANGMAN_WORDS_TABLE . '
							WHERE ' . $this->db->sql_in_set('word_id', $sql_in);
					$this->db->sql_query($sql);

					// Update or Insert this user's score
					$sql_arr = array(
						'user_id'	=> $this->user->data['user_id'],
					);
					$sql = 'SELECT solve_pts, total_pts FROM ' . HANGMAN_SCORE_TABLE . '
							WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
					if (!empty ($row))
					{
						$sql_arr = array(
							'solve_pts'		=> $row['solve_pts'] + $game_points,
							'total_pts'		=> $row['total_pts'] + $game_points,
						);
						$sql = 'UPDATE ' . HANGMAN_SCORE_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
								WHERE user_id = ' . (int) $this->user->data['user_id'];
						$this->db->sql_query($sql);
					}
					else
					{
						$sql_arr = array(
							'user_id'		=> $this->user->data['user_id'],
							'solve_pts'		=> $game_points,
							'total_pts'		=> $game_points,
							'word_pts'		=> 0,
						);
						$sql = 'INSERT INTO ' . HANGMAN_SCORE_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
						$this->db->sql_query($sql);
					}

					// display message about successful operation
					$message = $this->language->lang('HANGMAN_POINTS_SAVED');
					trigger_error($message	. $this->back_link($this->game_action, $this->language->lang('TO_GAME'))
											. $this->back_link($this->word_action, $this->language->lang('TO_WORD_INPUT'))
											. $this->back_link($this->rank_action, $this->language->lang('TO_SCORE_TABLE')), E_USER_NOTICE);
				}

				// and calculate the length of the rows to display them
				$total_letters = count ($letters);
				$letter_row = $total_letters/2;
				if ((int) $letter_row < $letter_row)
				{
					$letter_row = (int) $letter_row + 1;
				}

				// Define the path to images
				$image_path = 'ext/mot/hangman/styles/all/theme/images/';

				// Get a quote from the table
				$sql_in = array($this->user->data['user_id']);
				$sql = 'SELECT word_id, hangman_word FROM ' . HANGMAN_WORDS_TABLE . '
						WHERE ' . $this->db->sql_in_set('creator_id', $sql_in, true);
				$result = $this->db->sql_query($sql);
				$quotes = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$this->template->assign_vars(array(
					'GAME_DESC'					=> $this->language->lang('HANGMAN_DESC', $this->config['mot_hangman_points_letter'], $this->config['mot_hangman_points_win'], $this->config['mot_hangman_points_loose']),
					'HANGMAN_LETTERS'			=> json_encode($letters),
					'HANGMAN_TOTAL_LETTERS'		=> $total_letters,
					'HANGMAN_LETTER_ROW'		=> $letter_row,
					'HANGMAN_LIVES'				=> $this->language->lang('HANGMAN_LIVES', $this->config['mot_hangman_lives']),
					'HANGMAN_NUMBER_OF_LIVES'	=> $this->config['mot_hangman_lives'],
					'CLICK_START_FIRST'			=> $this->language->lang('HANGMAN_NEW_QUOTE_TO'),
					'HANGMAN_QUOTES'			=> json_encode($quotes),
					'IMAGE_PATH'				=> $image_path,
					'LETTER_POINTS'				=> $this->config['mot_hangman_points_letter'],
					'WIN_POINTS'				=> $this->config['mot_hangman_points_win'],
					'LOOSE_POINTS'				=> $this->config['mot_hangman_points_loose'],
					'U_ACTION'					=> $this->u_action,
				));
				$selected_tab = 1;
				break;

			case 2:
				$input_points = $this->config['mot_hangman_points_word'];
				add_form_key('hangman_quote_input');

				$this->u_action = $this->helper->route('mot_hangman_main_controller', ['tab' => '2']);

				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key('hangman_quote_input'))
					{
						trigger_error($this->language->lang('FORM_INVALID') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
					}

					$quote = $this->request->variable('hangman_quote_text', '', true);
					$hash = $this->get_hash($quote);
					$sql_arr = array(
						'hangman_word_hash'	=> $hash,
					);
					$sql = 'SELECT word_id FROM ' . HANGMAN_WORDS_TABLE . '
							WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if (empty($row) && $quote != '')
					{
						// quote doesn't exist, insert it into the table
						$sql_arr = array(
							'creator_id'			=> $this->user->data['user_id'],
							'hangman_word'			=> $quote,
							'hangman_word_hash'		=> $hash,
						);
						$sql = 'INSERT INTO ' . HANGMAN_WORDS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
						$this->db->sql_query($sql);

						// Update or insert the user's points
						$sql_arr = array(
							'user_id'	=> $this->user->data['user_id'],
						);
						$sql = 'SELECT total_pts, word_pts FROM ' . HANGMAN_SCORE_TABLE . '
								WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						if (!empty($row))
						{
							// user exists, update the data
							$sql_arr = array(
								'total_pts'	=> $row['total_pts'] + $input_points,
								'word_pts'	=> $row['word_pts'] + $input_points,
							);
							$sql = 'UPDATE ' . HANGMAN_SCORE_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
									WHERE user_id = ' . (int) $this->user->data['user_id'];
							$this->db->sql_query($sql);
						}
						else
						{
							// user doesn't exist, insert the data
							$sql_arr = array(
								'user_id'	=> $this->user->data['user_id'],
								'solve_pts'	=> 0,
								'total_pts'	=> $input_points,
								'word_pts'	=> $input_points,
							);
							$sql = 'INSERT INTO ' . HANGMAN_SCORE_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
							$this->db->sql_query($sql);
						}

						// display message about successful operation
						$message = $this->language->lang('HANGMAN_WORD_SAVED', $input_points);
						trigger_error($message	. $this->back_link($this->game_action, $this->language->lang('TO_GAME'))
												. $this->back_link($this->word_action, $this->language->lang('TO_WORD_INPUT'))
												. $this->back_link($this->rank_action, $this->language->lang('TO_SCORE_TABLE')), E_USER_NOTICE);
					}
					else
					{
						trigger_error($this->language->lang('HANGMAN_WORD_EXISTS') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
					}
				}

				$lc_letters = explode(',', $lc_letters);
				$this->template->assign_vars(array(
					'HANGMAN_QUOTE_INPUT_EXPL'	=> $this->language->lang('HANGMAN_QUOTE_INPUT_EXPL', $input_points),
					'HANGMAN_LC_LETTERS'		=> json_encode($lc_letters),
					'U_ACTION'					=> $this->u_action . '&amp;action=submit',
				));
				$selected_tab = 2;
				break;

			case 3:
				// set parameter for pagination
				$start = $this->request->is_set('start') ? $this->request->variable('start', 0) : 0;
				$limit = 25;	// max 25 lines per page

				// Get total numbers of players in score table
				$count_query = "SELECT COUNT(user_id) AS 'user_count' FROM " . HANGMAN_SCORE_TABLE;
				$result = $this->db->sql_query($count_query);
				$row = $this->db->sql_fetchrow($result);
				$count_rankings = $row['user_count'];
				$this->db->sql_freeresult($result);

				// Get data from tables
				$sql_arr = array(
					'SELECT'    => 'u.user_id, u.username, u.user_colour, h.user_id, h.solve_pts, h.total_pts, h.word_pts',
					'FROM'		=> array(
						USERS_TABLE        	=> 'u',
						HANGMAN_SCORE_TABLE	=> 'h',
					),
					'WHERE'		=> 'u.user_id = h.user_id',
				);
				$sql = $this->db->sql_build_query('SELECT', $sql_arr);
				$sql .= ' ORDER BY h.total_pts DESC';
				$result = $this->db->sql_query_limit( $sql, $limit, $start );
				$user_ranking = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$i = $start;
				foreach ($user_ranking as $row)
				{
					$i++;
					$this->template->assign_block_vars('rankings', array(
						'RANK'			=> $i,
						'USERNAME'		=> $row['username'],
						'USER_ID'		=> $row['user_id'],
						'USER_COLOUR'	=> $row['user_colour'],
						'TOTAL_POINTS'	=> $row['total_pts'],
						'GAME_POINTS'	=> $row['solve_pts'],
						'WORD_POINTS'	=> $row['word_pts'],
					));
				}

				//base url for pagination, filtering and sorting
				$base_url = $this->helper->route('mot_hangman_main_controller', ['tab' => '3']);

				// Load pagination
				$start = $pagination->validate_start($start, $limit, $count_rankings);
				$pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_rankings, $limit, $start);

				$selected_tab = 3;
				break;

		}

		$this->template->assign_vars(array(
			'SELECTED_TAB'		=> $selected_tab,
			'TAB_1'				=> $this->helper->route('mot_hangman_main_controller', ['tab' => '1']),
			'TAB_2'				=> $this->helper->route('mot_hangman_main_controller', ['tab' => '2']),
			'TAB_3'				=> $this->helper->route('mot_hangman_main_controller', ['tab' => '3']),
		));
		return $this->helper->render('hangman.html', $this->language->lang('HANGMAN'));
	}

	/**
	 * Generate back link for main controller
	 * @param	$u_action
	 *		$language	language variable
	 *
	 * @return	string
	 */
	private function back_link($u_action, $lang_str)
	{
		return '<br /><br /><a href="' . $u_action . '">&laquo; ' . $lang_str . '</a>';
	}

	/**
	* Generate a hash value to check for redundant quotes
	* @param	string	original string to get the hash value from
	*
	* @return	integer	hash value with length of string as last digits
	*/
	private function get_hash($original_string)
	{
		setlocale (LC_CTYPE, 'C');
		return sprintf('%u', crc32(strtolower($original_string))) . strlen($original_string);
	}
}
