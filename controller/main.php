<?php
/*
*
* @package Hangman v0.5.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace mot\hangman\controller;

use phpbb\language\language_file_loader;

class main
{
	/** @var \phpbb\auth\auth */
	protected $auth;

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

	/** @var \phpbb\pagination  */
	protected $pagination;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $php_ext;

	/** @var string mot.usermap.tables.usermap_users */
	protected $mot_hangman_score_table;

	/** @var string mot.usermap.tables.usermap_poi */
	protected $mot_hangman_words_table;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\extension\manager $phpbb_extension_manager, \phpbb\controller\helper $helper,
								\phpbb\language\language $language, \phpbb\pagination $pagination, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext,
								$mot_hangman_score_table, $mot_hangman_words_table)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->phpbb_extension_manager 	= $phpbb_extension_manager;
		$this->helper = $helper;
		$this->language = $language;
		$this->pagination = $pagination;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->hangman_score_table = $mot_hangman_score_table;
		$this->hangman_words_table = $mot_hangman_words_table;

		$this->ext_path = $this->phpbb_extension_manager->get_extension_path('mot/hangman', true);
	}

	public function display()
	{
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
		$this->summary_action = $this->helper->route('mot_hangman_main_controller', ['tab' => '4']);

		// Get the possible letters from the default language file
		$lang_arr = [];
		$default_lang = new language_file_loader($this->root_path, $this->php_ext);
		$default_lang->set_extension_manager($this->phpbb_extension_manager);
		$default_lang->load_extension('mot/hangman', 'common', [$this->config['default_lang'], 'en'], $lang_arr);
		$letters = explode(',', $lang_arr['MOT_HANGMAN_LETTERS']);
		$lc_letters = mb_strtolower($lang_arr['MOT_HANGMAN_LETTERS'], 'UTF-8');

		// Get some config variables first
		$delete_term = $this->config['mot_hangman_autodelete'];
		$enforce_term = $this->config['mot_hangman_enforce_term'];
		$input_points = $this->config['mot_hangman_points_word'];

		// Define some variables
		$allow_user = true;	// Assume that this player is not blocked

		$tab = $this->request->variable('tab', 0);
		switch ($tab)
		{
			case 0:
			case 1:
			default:
				add_form_key('hangman_game_frm');

				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key('hangman_game_frm'))
					{
						trigger_error($this->language->lang('FORM_INVALID') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
					}

					$game_points = $this->request->variable('score', 0);
					$word_id = $this->request->variable('word_id', 0);

					// Delete the used quote from database (if applicable)
					if ($delete_term)
					{
						$sql_in = [$word_id];
						$sql = 'DELETE FROM ' . $this->hangman_words_table . '
								WHERE ' . $this->db->sql_in_set('word_id', $sql_in);
						$this->db->sql_query($sql);
					}

					// Update or Insert this user's score
					$sql_arr = [
						'user_id'	=> $this->user->data['user_id'],
					];
					$sql = 'SELECT solve_pts, total_pts FROM ' . $this->hangman_score_table . '
							WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
					if (!empty ($row))
					{
						$sql_arr = [
							'solve_pts'		=> $row['solve_pts'] + $game_points,
							'total_pts'		=> $row['total_pts'] + $game_points,
						];
						$sql = 'UPDATE ' . $this->hangman_score_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
								WHERE user_id = ' . (int) $this->user->data['user_id'];
						$this->db->sql_query($sql);
					}
					else
					{
						$sql_arr = [
							'user_id'		=> $this->user->data['user_id'],
							'solve_pts'		=> $game_points,
							'total_pts'		=> $game_points,
							'word_pts'		=> 0,
						];
						$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
						$this->db->sql_query($sql);
					}

					// display message about successful operation
					$message = $this->language->lang('MOT_HANGMAN_POINTS_SAVED');
					meta_refresh(3, $this->game_action);
					trigger_error($message	. $this->back_link($this->game_action, $this->language->lang('MOT_HANGMAN_TO_GAME'))
											. $this->back_link($this->word_action, $this->language->lang('MOT_HANGMAN_TO_WORD_INPUT'))
											. $this->back_link($this->rank_action, $this->language->lang('MOT_HANGMAN_TO_SCORE_TABLE'))
											. $this->back_link($this->summary_action, $this->language->lang('MOT_HANGMAN_TO_SUMMARY')), E_USER_NOTICE);
				}

				// Check if users should be blocked from playing
				if ($enforce_term)
				{
					$sql_in = [$this->user->data['user_id']];
					$sql = 'SELECT solve_pts, word_pts FROM ' . $this->hangman_score_table . '
							WHERE ' . $this->db->sql_in_set('user_id', $sql_in);
					$result = $this->db->sql_query($sql);
					$user_row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
					if (!empty($user_row))
					{
						$config_ratio = $this->config['mot_hangman_enforce_term_ratio'];
						if ($user_row['word_pts'] == 0)	// prevent division by zero
						{
							$ratio = $user_row['solve_pts'];	// use the difference instead of the ratio
						}
						else
						{
							$ratio = $user_row['solve_pts'] / $user_row['word_pts'];
						}
						if ($ratio > $config_ratio)
						{
							$allow_user = false;
							$min_term_necessary = intdiv(intdiv($user_row['solve_pts'], $config_ratio) + 1 - $user_row['word_pts'], $input_points) + 1;
							$this->template->assign_vars([
								'NO_GAME_EXPLANATION'	=> $this->language->lang('MOT_HANGMAN_GAME_BLOCKED', (int) $min_term_necessary),
								'LINK_TO_TERM_INPUT'	=> $this->back_link($this->word_action, $this->language->lang('MOT_HANGMAN_TO_WORD_INPUT')),
							]);
							meta_refresh(12, $this->word_action);
						}
					}
				}

				// Calculate the length of the rows to display usable letters
				$total_letters = count ($letters);
				$letter_row = $total_letters/2;
				if ((int) $letter_row < $letter_row)
				{
					$letter_row = (int) $letter_row + 1;
				}

				// Get the quotes from the table
				$sql_in = [$this->user->data['user_id']];
				$sql = 'SELECT word_id, hangman_word, hangman_category FROM ' . $this->hangman_words_table . '
						WHERE ' . $this->db->sql_in_set('creator_id', $sql_in, true);
				$result = $this->db->sql_query($sql);
				$quotes = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);
				$quote_count = count($quotes);
				$quote = $quote_count > 0 ? $quotes[array_rand($quotes)] : [];

				$game_desc = $this->language->lang('MOT_HANGMAN_DESC', $this->config['mot_hangman_points_letter'], $this->config['mot_hangman_points_win'], $this->config['mot_hangman_points_loose']);
				if ($delete_term)
				{
					$game_desc .= $this->language->lang('MOT_HANGMAN_DESC_DEL_TERM');
				}

				$this->template->assign_vars([
					'ALLOW_USER'				=> $allow_user,
					'GAME_DESC'					=> $game_desc,
					'MOT_HANGMAN_LETTERS'		=> json_encode($letters),
					'HANGMAN_TOTAL_LETTERS'		=> $total_letters,
					'HANGMAN_LETTER_ROW'		=> $letter_row,
					'MOT_HANGMAN_LIVES'			=> $this->language->lang('MOT_HANGMAN_LIVES', $this->config['mot_hangman_lives']),
					'HANGMAN_NUMBER_OF_LIVES'	=> $this->config['mot_hangman_lives'],
					'CLICK_START_FIRST'			=> $this->language->lang('MOT_HANGMAN_NEW_QUOTE_TO'),
					'HANGMAN_QUOTE'				=> json_encode($quote),
					'QUOTE_COUNT'				=> $quote_count,
					'LETTER_POINTS'				=> $this->config['mot_hangman_points_letter'],
					'WIN_POINTS'				=> $this->config['mot_hangman_points_win'],
					'LOOSE_POINTS'				=> $this->config['mot_hangman_points_loose'],
					'ENABLE_EVADE_PUNISH'		=> $this->config['mot_hangman_evade_enable'] == 1 ? true : false,
					'SHOW_TERM_WHEN_LOST'		=> $this->config['mot_hangman_show_term'] == 1 ? true : false,
					'U_ACTION'					=> $this->game_action,
					'AJAX_CALL'					=> $this->helper->route('mot_hangman_ajax_controller'),
				]);
				$selected_tab = 1;
				break;

			case 2:
				add_form_key('hangman_quote_input');

				$this->u_action = $this->word_action;

				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key('hangman_quote_input'))
					{
						meta_refresh(1, $this->word_action);
						trigger_error($this->language->lang('FORM_INVALID') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
					}

					$quote = $this->request->variable('hangman_quote_text', '', true);
					$hash = $this->get_hash($quote);
					$sql_arr = [
						'hangman_word_hash'	=> $hash,
					];
					$sql = 'SELECT word_id FROM ' . $this->hangman_words_table . '
							WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if (empty($row) && $quote != '')
					{
						// quote doesn't exist, insert it into the table
						$sql_arr = [
							'creator_id'			=> $this->user->data['user_id'],
							'hangman_word'			=> $quote,
							'hangman_word_hash'		=> $hash,
							'hangman_category'		=> $this->request->variable('hangman_quote_category', '', true)
						];
						$sql = 'INSERT INTO ' . $this->hangman_words_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
						$this->db->sql_query($sql);

						// Update or insert the user's points
						$sql_arr = [
							'user_id'	=> $this->user->data['user_id'],
						];
						$sql = 'SELECT total_pts, word_pts FROM ' . $this->hangman_score_table . '
								WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						if (!empty($row))
						{
							// user exists, update the data
							$sql_arr = [
								'total_pts'	=> $row['total_pts'] + $input_points,
								'word_pts'	=> $row['word_pts'] + $input_points,
							];
							$sql = 'UPDATE ' . $this->hangman_score_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
									WHERE user_id = ' . (int) $this->user->data['user_id'];
						}
						else
						{
							// user doesn't exist, insert the data
							$sql_arr = [
								'user_id'	=> $this->user->data['user_id'],
								'solve_pts'	=> 0,
								'total_pts'	=> $input_points,
								'word_pts'	=> $input_points,
							];
							$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
						}
						$this->db->sql_query($sql);

						// display message about successful operation
						meta_refresh(2, $this->word_action);
						$message = $this->language->lang('MOT_HANGMAN_WORD_SAVED', $input_points);
						trigger_error($message	. $this->back_link($this->game_action, $this->language->lang('MOT_HANGMAN_TO_GAME'))
												. $this->back_link($this->word_action, $this->language->lang('MOT_HANGMAN_TO_WORD_INPUT'))
												. $this->back_link($this->rank_action, $this->language->lang('MOT_HANGMAN_TO_SCORE_TABLE'))
												. $this->back_link($this->summary_action, $this->language->lang('MOT_HANGMAN_TO_SUMMARY')), E_USER_NOTICE);
					}
					else
					{
						meta_refresh(1, $this->word_action);
						trigger_error($this->language->lang('MOT_HANGMAN_WORD_EXISTS') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
					}
				}

				$lc_letters = explode(',', $lc_letters);
				$this->template->assign_vars([
					'MOT_HANGMAN_QUOTE_INPUT_EXPL'	=> $this->language->lang('MOT_HANGMAN_QUOTE_INPUT_EXPL', implode(', ', $letters), $this->config['mot_hangman_punctuation_marks']),
					'MOT_HANGMAN_INPUT_POINTS'		=> $this->language->lang('MOT_HANGMAN_INPUT_POINTS', (int) $input_points),
					'HANGMAN_LC_LETTERS'			=> json_encode($lc_letters),
					'TERM_MIN_LENGTH'				=> $this->config['mot_hangman_term_length'],
					'U_ACTION'						=> $this->u_action . '&amp;action=submit',
				]);
				$selected_tab = 2;
				break;

			case 3:
				// set parameter for pagination
				$start = $this->request->is_set('start') ? $this->request->variable('start', 0) : 0;
				$limit = $this->config['mot_hangman_rows_per_page'];	// max lines per page

				// Get total numbers of players in score table
				$count_query = "SELECT COUNT(user_id) AS 'user_count' FROM " . $this->hangman_score_table;
				$result = $this->db->sql_query($count_query);
				$row = $this->db->sql_fetchrow($result);
				$count_rankings = $row['user_count'];
				$this->db->sql_freeresult($result);

				// Get data from tables
				$sql_arr = [
					'SELECT'    => 'u.user_id, u.username, u.user_colour, h.user_id, h.solve_pts, h.total_pts, h.word_pts',
					'FROM'		=> [
						USERS_TABLE        	=> 'u',
						$this->hangman_score_table	=> 'h',
					],
					'WHERE'		=> 'u.user_id = h.user_id',
				];
				$sql = $this->db->sql_build_query('SELECT', $sql_arr);
				$sql .= ' ORDER BY h.total_pts DESC';
				$result = $this->db->sql_query_limit( $sql, $limit, $start );
				$user_ranking = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$i = $start;
				foreach ($user_ranking as $row)
				{
					$i++;
					$this->template->assign_block_vars('rankings', [
						'RANK'						=> $i,
						'USERNAME'					=> $row['username'],
						'USER_ID'					=> $row['user_id'],
						'USER_COLOUR'				=> $row['user_colour'],
						'MOT_HANGMAN_TOTAL_POINTS'	=> $row['total_pts'],
						'MOT_HANGMAN_GAME_POINTS'	=> $row['solve_pts'],
						'MOT_HANGMAN_WORD_POINTS'	=> $row['word_pts'],
					]);
				}

				//base url for pagination, filtering and sorting
				$base_url = $this->rank_action;

				// Load pagination
				$start = $this->pagination->validate_start($start, $limit, $count_rankings);
				$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $count_rankings, $limit, $start);

				$selected_tab = 3;
				break;

			case 4:
				// set parameter for pagination
				$start = $this->request->is_set('start') ? $this->request->variable('start', 0) : 0;
				$limit = $this->config['mot_hangman_rows_per_page'];	// max lines per page

				// Get total number of terms
				$count_query = "SELECT COUNT(word_id) AS 'term_count' FROM " . $this->hangman_words_table;
				$result = $this->db->sql_query($count_query);
				$row = $this->db->sql_fetchrow($result);
				$term_count = $row['term_count'];
				$this->db->sql_freeresult($result);

				$count_query = "SELECT COUNT(word_id) AS 'term_count' FROM " . $this->hangman_words_table . '
								WHERE creator_id = ' . (int) $this->user->data['user_id'];
				$result = $this->db->sql_query($count_query);
				$row = $this->db->sql_fetchrow($result);
				$user_term_count = $row['term_count'];
				$this->db->sql_freeresult($result);

				$sql = 'SELECT * FROM ' . $this->hangman_words_table . '
						WHERE creator_id = ' . (int) $this->user->data['user_id'];
				$result = $this->db->sql_query_limit( $sql, $limit, $start );
				$user_term = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				foreach ($user_term as $row)
				{
					$this->template->assign_block_vars('terms', [
						'MOT_HANGMAN_TERM'		=> $row['hangman_word'],
						'MOT_HANGMAN_CATEGORY'	=> $row['hangman_category'],
					]);
				}

				//base url for pagination, filtering and sorting
				$base_url = $this->summary_action;

				// Load pagination
				$start = $this->pagination->validate_start($start, $limit, $user_term_count);
				$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $user_term_count, $limit, $start);

				$this->template->assign_vars([
					'MOT_HANGMAN_LIVES'					=> $this->config['mot_hangman_lives'],
					'MOT_HANGMAN_POINTS_WIN'			=> $this->config['mot_hangman_points_win'],
					'MOT_HANGMAN_POINTS_LOOSE'			=> $this->config['mot_hangman_points_loose'],
					'MOT_HANGMAN_POINTS_LETTER'			=> $this->config['mot_hangman_points_letter'],
					'MOT_HANGMAN_POINTS_WORD'			=> $this->config['mot_hangman_points_word'],
					'MOT_HANGMAN_EVADE_ENABLE'			=> $this->config['mot_hangman_evade_enable'] == 1 ? $this->language->lang('YES') : $this->language->lang('NO'),
					'MOT_HANGMAN_TERMS_AVAILABLE'		=> $term_count,
					'MOT_HANGMAN_USER_TERMS_AVAILABLE'	=> $user_term_count,
				]);

				$this->language->add_lang('info_acp_hangman', 'mot/hangman');

				$selected_tab = 4;
				break;

		}

		$image_path = append_sid("{$this->ext_path}styles/all/theme/images/hm");
		$pos = strrpos($image_path, '?', 0);
		if ($pos !== false)
		{
			$image_path = substr($image_path, 0, $pos);
		}

		$this->template->assign_vars([
			'SHOW_CATEGORY'			=> $this->config['mot_hangman_category_enable'] == 1 ? true : false,
			'ENFORCE_CATEGORY'		=> $this->config['mot_hangman_category_enforce'] == 1 ? true : false,
			'ALLOW_TERM_INPUT'		=> $this->auth->acl_get('u_mot_create_search_term'),
			'SELECTED_TAB'			=> $selected_tab,
			'TAB_1'					=> $this->game_action,
			'TAB_2'					=> $this->word_action,
			'TAB_3'					=> $this->rank_action,
			'TAB_4'					=> $this->summary_action,
			'IMAGE_PATH'			=> $image_path,
			'ALLOWED_PUNCT_MARKS'	=> $this->config['mot_hangman_punctuation_marks'],
		]);
		return $this->helper->render('@mot_hangman/hangman.html', $this->language->lang('MOT_HANGMAN'));
	}

	/**
	* Handles cheaters who are trying to evade a loosing game
	*/
	public function hangman_ajax_response()
	{
		$game_points = $this->request->variable('score', 0);
		$word_id = $this->request->variable('word_id', 0);

		// Delete the used quote from database (if applicable)
		if ($this->config['mot_hangman_autodelete'])
		{
			$sql_in = [$word_id];
			$sql = 'DELETE FROM ' . $this->hangman_words_table . '
					WHERE ' . $this->db->sql_in_set('word_id', $sql_in);
			$this->db->sql_query($sql);
		}

		// Update or Insert this user's score
		$sql_arr = [
			'user_id'	=> $this->user->data['user_id'],
		];
		$sql = 'SELECT solve_pts, total_pts FROM ' . $this->hangman_score_table . '
				WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!empty ($row))
		{
			$sql_arr = [
				'solve_pts'		=> $row['solve_pts'] + $game_points,
				'total_pts'		=> $row['total_pts'] + $game_points,
			];
			$sql = 'UPDATE ' . $this->hangman_score_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
					WHERE user_id = ' . (int) $this->user->data['user_id'];
		}
		else
		{
			$sql_arr = [
				'user_id'		=> $this->user->data['user_id'],
				'solve_pts'		=> $game_points,
				'total_pts'		=> $game_points,
				'word_pts'		=> 0,
			];
			$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		}
		$this->db->sql_query($sql);
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
//		setlocale (LC_CTYPE, 'C');
		return sprintf('%u', crc32(strtolower($original_string))) . strlen($original_string);
	}

}
