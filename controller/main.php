<?php
/*
*
* @package Hangman v0.11.3
* @author Mike-on-Tour
* @copyright (c) 2021 - 2025 Mike-on-Tour
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

	/** @var \phpbb\notification\manager */
	protected $notification_manager;

	/** @var \phpbb\pagination  */
	protected $pagination;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var \mot\hangman\includes\mot_hangman_functions */
	protected $mot_hangman_functions;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $php_ext;

	/** @var string mot.hangman.tables.mot_hangman_fame */
	protected $mot_hangman_fame_table;

	/** @var string mot.hangman.tables.mot_hangman_fame */
	protected $mot_hangman_fame_month_table;

	/** @var string mot.hangman.tables.mot_hangman_fame */
	protected $mot_hangman_fame_year_table;

	/** @var string mot.hangman.tables.mot_hangman_score */
	protected $mot_hangman_score_table;

	/** @var string mot.hangman.tables.mot_hangman_words */
	protected $mot_hangman_words_table;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\extension\manager $phpbb_extension_manager, \phpbb\controller\helper $helper, \phpbb\language\language $language,
								\phpbb\notification\manager $notification_manager, \phpbb\pagination $pagination, \phpbb\request\request_interface $request,
								\phpbb\template\template $template, \phpbb\user $user, \mot\hangman\includes\mot_hangman_functions $mot_hangman_functions, $root_path, $php_ext,
								$mot_hangman_fame_table, $mot_hangman_fame_month_table, $mot_hangman_fame_year_table, $mot_hangman_score_table, $mot_hangman_words_table)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->phpbb_extension_manager 	= $phpbb_extension_manager;
		$this->helper = $helper;
		$this->language = $language;
		$this->notification_manager = $notification_manager;
		$this->pagination = $pagination;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->mot_hangman_functions = $mot_hangman_functions;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->hangman_fame_table = $mot_hangman_fame_table;
		$this->hangman_fame_month_table = $mot_hangman_fame_month_table;
		$this->hangman_fame_year_table = $mot_hangman_fame_year_table;
		$this->hangman_score_table = $mot_hangman_score_table;
		$this->hangman_words_table = $mot_hangman_words_table;

		$this->ext_path = $this->phpbb_extension_manager->get_extension_path('mot/hangman', true);
		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/hangman');
		$this->ext_data = $this->md_manager->get_metadata();
	}

	public function display()
	{
		if ($this->config['mot_hangman_enable'] || $this->user->data['user_type'] == USER_FOUNDER)
		{
			// Check first for a new month or year and update FAME_MONTH_TABLE  and FAME_YEAR_TABLE if applicable
			$this->mot_hangman_functions->check_month_year();

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

			// Check permission
			if (!$this->auth->acl_get('u_mot_play_hangman'))
			{
				trigger_error($this->language->lang('NO_AUTH_OPERATION'));
			}

			$this->game_action = $this->helper->route('mot_hangman_main_controller', ['tab' => 'game']);
			$this->word_action = $this->helper->route('mot_hangman_main_controller', ['tab' => 'word']);
			$this->rank_action = $this->helper->route('mot_hangman_main_controller', ['tab' => 'rank']);
			$this->fame_action = $this->helper->route('mot_hangman_main_controller', ['tab' => 'fame']);
			$this->summary_action = $this->helper->route('mot_hangman_main_controller', ['tab' => 'summ']);

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
			$user_id = $this->user->data['user_id'];

			$tab = $this->request->variable('tab', 'game');
			$tab = (($tab == 'rank' && !$this->config['mot_hangman_enable_rank']) || ($tab == 'fame' && !$this->config['mot_hangman_enable_fame'])) ? 'game' : $tab;
			switch ($tab)
			{
				case 'game':
					$form_key = 'hangman_game_frm';
					add_form_key($form_key);

					$congrat = $this->request->variable('congrat', false);
					if ($this->request->is_set_post('submit'))
					{
						if (!check_form_key($form_key))
						{
							trigger_error($this->language->lang('FORM_INVALID') . $this->back_link($this->game_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
						}

						// Define the $up_points variable with a 0 value to indicate that no rank has been gained
						$up_points = 0;
						// Check first whether the page with congratulations for gaining one or more steps in the ranking has been displayed, if not we can do all the things following
						if (!$congrat)
						{
							$game_points = $this->request->variable('score', 0);
							$word_id = $this->request->variable('word_id', 0);

							// Delete the used quote from database (if applicable)
							if ($delete_term)
							{
								$sql = 'DELETE FROM ' . $this->hangman_words_table . '
										WHERE ' . $this->db->sql_in_set('word_id', [$word_id]);
								$this->db->sql_query($sql);
							}

							// Update or Insert this user's score
							$sql_arr = [
								'user_id'	=> $user_id,
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
										WHERE user_id = ' . (int) $user_id;
							}
							else
							{
								$sql_arr = [
									'user_id'		=> $user_id,
									'solve_pts'		=> $game_points,
									'total_pts'		=> $game_points,
									'word_pts'		=> 0,
								];
								$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
							}
							$this->db->sql_query($sql);

							// Update the new rankings and get the new rank of current user (false if no better rank gained)
							$user_rank_status = $this->calc_new_ranks($user_id);

							// Trigger notifications about loosing current rank if applicable
							$this->trigger_notification();

							// Update hall of fame (we do this independantly from its enabling status)
							$up_points = $this->save_to_fame($game_points);

							// All checks are done, now we can set the old ranks to the new ones
							$this->set_ranks();

							// Check if congratulation on gaining rank is enabled and current user is eligible for a congratulation
							// We do this last in order to ensure that everything is tidy in case this user is slow on closing the modal window
							if ($this->config['mot_hangman_gain_rank'] && !empty($user_rank_status))
							{
								$this->template->assign_vars([
									'U_ACTION'				=> $this->game_action,
									'MOT_HANGMAN_CONGR'		=> $this->language->lang('MOT_HANGMAN_RANK_GAINED', $user_rank_status['old_rank'], $user_rank_status['new_rank']),
									'MOT_HANGMAN_ACTIVE'	=> true,
									'MOT_HANGMAN_COPYRIGHT'	=> $this->ext_data['extra']['display-name'] . ' ' . $this->ext_data['version'] . ' &copy; Mike-on-Tour (<a href="' . $this->ext_data['homepage'] . '" target="_blank" rel="noopener">' . $this->ext_data['homepage'] . '</a>)',
								]);

								// Add breadcrumbs link
								$this->template->assign_block_vars('navlinks', [
									'FORUM_NAME'	=> $this->language->lang('MOT_HANGMAN'),
									'U_VIEW_FORUM'	=> $this->helper->route('mot_hangman_main_controller'),
								]);

								return $this->helper->render('@mot_hangman/hangman_congrat.html', $this->language->lang('MOT_HANGMAN'));
							}
						}

						// display message about successful operation
						$message = $this->language->lang('MOT_HANGMAN_POINTS_SAVED');
						$message .= $up_points > 0 ? '<br>' . $this->language->lang('MOT_HANGMAN_UP_ADDED', $up_points) : '';
						meta_refresh(4, $this->game_action);
						trigger_error($message	. $this->back_link($this->game_action, $this->language->lang('MOT_HANGMAN_TO_GAME'))
												. $this->back_link($this->word_action, $this->language->lang('MOT_HANGMAN_TO_WORD_INPUT'))
												. $this->back_link($this->rank_action, $this->language->lang('MOT_HANGMAN_TO_SCORE_TABLE'))
												. ($this->config['mot_hangman_enable_fame'] ? $this->back_link($this->fame_action, $this->language->lang('MOT_HANGMAN_TO_FAME')) : '')
												. $this->back_link($this->summary_action, $this->language->lang('MOT_HANGMAN_TO_SUMMARY')), E_USER_NOTICE);
					}

					// Check if users should be blocked from playing
					if ($enforce_term)
					{
						$sql = 'SELECT solve_pts, word_pts FROM ' . $this->hangman_score_table . '
								WHERE ' . $this->db->sql_in_set('user_id', [$user_id]);
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
									'MOT_HANGMAN_NO_GAME_EXPLANATION'	=> $this->language->lang('MOT_HANGMAN_GAME_BLOCKED', (int) $min_term_necessary),
									'MOT_HANGMAN_LINK_TO_TERM_INPUT'	=> $this->back_link($this->word_action, $this->language->lang('MOT_HANGMAN_TO_WORD_INPUT')),
								]);
								meta_refresh(12, $this->word_action);
							}
						}
					}

					// Get the quotes from the table
					$sql_ary = [
						'SELECT'		=> 'w.word_id, w.creator_id, w.hangman_word, w.hangman_category, u.username',

						'FROM'			=> [$this->hangman_words_table	=> 'w'],

						'LEFT_JOIN'		=> [
								[
									'FROM'	=> [USERS_TABLE	=> 'u'],
									'ON'	=> 'u.user_id = w.creator_id',
								],
						],

						'WHERE'			=> $this->db->sql_in_set('w.creator_id', [$user_id], true),
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_ary);
					$result = $this->db->sql_query($sql);
					$quotes = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					// Select a random quote
					$quote_count = count($quotes);
					shuffle($quotes);		// Might this result in better randomly selecting a term?
					$quote = $quote_count ? $quotes[array_rand($quotes)] : [];

					if (!empty($quote))
					{
						$quote['word_len'] = mb_strlen($quote['hangman_word']);
						$quote['hangman_word'] = $this->encode($quote['hangman_word'], $quote['word_len']);			// Obscure the search term in order to prevent cheaters from reading it from the download stream
					}

					$game_desc = $this->language->lang('MOT_HANGMAN_DESC', $this->config['mot_hangman_points_letter'], $this->config['mot_hangman_points_win'], $this->config['mot_hangman_points_loose']);
					if ($delete_term)
					{
						$game_desc .= $this->language->lang('MOT_HANGMAN_DESC_DEL_TERM');
					}

					$this->template->assign_vars([
						'MOT_HANGMAN_ALLOW_USER'				=> $allow_user,
						'MOT_HANGMAN_GAME_DESC'					=> $game_desc,
						'MOT_HANGMAN_LETTERS'					=> json_encode($letters),
						'MOT_HANGMAN_LIVES'						=> $this->language->lang('MOT_HANGMAN_LIVES', $this->config['mot_hangman_lives']),
						'MOT_HANGMAN_NUMBER_OF_LIVES'			=> $this->config['mot_hangman_lives'],
						'MOT_HANGMAN_CLICK_START_FIRST'			=> $this->language->lang('MOT_HANGMAN_NEW_QUOTE_TO'),
						'MOT_HANGMAN_QUOTE'						=> json_encode($quote),
						'MOT_HANGMAN_LETTER_POINTS'				=> $this->config['mot_hangman_points_letter'],
						'MOT_HANGMAN_WIN_POINTS'				=> $this->config['mot_hangman_points_win'],
						'MOT_HANGMAN_LOOSE_POINTS'				=> $this->config['mot_hangman_points_loose'],
						'MOT_HANGMAN_ENABLE_EVADE_PUNISH'		=> $this->config['mot_hangman_evade_enable'],
						'MOT_HANGMAN_SHOW_TERM_WHEN_LOST'		=> $this->config['mot_hangman_show_term'],
						'MOT_HANGMAN_ENABLE_EXTRA_POINTS'		=> $this->config['mot_hangman_extra_points_enable'],
						'MOT_HANGMAN_EXTRA_POINTS'				=> $this->config['mot_hangman_extra_points'],
						'U_ACTION'								=> $this->game_action,
						'AJAX_CALL'								=> $this->helper->route('mot_hangman_ajax_controller'),
					]);
					break;

				case 'word':
					add_form_key('hangman_quote_input');

					$this->u_action = $this->word_action;

					$congrat = $this->request->variable('congrat', false);
					if ($this->request->is_set_post('submit'))
					{
						if (!check_form_key('hangman_quote_input'))
						{
							meta_refresh(1, $this->word_action);
							trigger_error($this->language->lang('FORM_INVALID') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
						}

						if (!$congrat)
						{
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
									'creator_id'			=> $user_id,
									'hangman_word'			=> $quote,
									'hangman_word_hash'		=> $hash,
									'hangman_category'		=> $this->request->variable('hangman_quote_category', '', true)
								];
								$sql = 'INSERT INTO ' . $this->hangman_words_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
								$this->db->sql_query($sql);

								// Update or insert the user's points
								$sql_arr = [
									'user_id'	=> $user_id,
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
											WHERE user_id = ' . (int) $user_id;
								}
								else
								{
									// user doesn't exist, insert the data
									$sql_arr = [
										'user_id'	=> $user_id,
										'solve_pts'	=> 0,
										'total_pts'	=> $input_points,
										'word_pts'	=> $input_points,
									];
									$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
								}
								$this->db->sql_query($sql);
							}
							else
							{
								meta_refresh(2, $this->word_action);
								trigger_error($this->language->lang('MOT_HANGMAN_WORD_EXISTS') . $this->back_link($this->u_action, $this->language->lang('BACK_TO_PREV')), E_USER_WARNING);
							}

							// Update the new rankings and get the new rank of current user (false if no better rank gained)
							$user_rank_status = $this->calc_new_ranks($user_id);

							// Trigger notifications about loosing current rank if applicable
							$this->trigger_notification();

							// Update hall of fame (we do this independantly from its enabling status)
							$up_points = $this->save_to_fame($input_points);

							// All checks are done, now we can set the old ranks to the new ones
							$this->set_ranks();

							// Check if congratulation on gaining rank is enabled and current user is eligible for a congratulation
							// We do this last in order to ensure that everything is tidy in case this user is slow on closing the modal window
							if ($this->config['mot_hangman_gain_rank'] && !empty($user_rank_status))
							{
								$this->template->assign_vars([
									'U_ACTION'				=> $this->word_action,
									'MOT_HANGMAN_CONGR'		=> $this->language->lang('MOT_HANGMAN_RANK_GAINED', $user_rank_status['old_rank'], $user_rank_status['new_rank']),
									'MOT_HANGMAN_ACTIVE'	=> true,
									'MOT_HANGMAN_UP_POINTS'	=> $up_points,
									'MOT_HANGMAN_COPYRIGHT'	=> $this->ext_data['extra']['display-name'] . ' ' . $this->ext_data['version'] . ' &copy; Mike-on-Tour (<a href="' . $this->ext_data['homepage'] . '" target="_blank" rel="noopener">' . $this->ext_data['homepage'] . '</a>)',
								]);

								// Add breadcrumbs link
								$this->template->assign_block_vars('navlinks', [
									'FORUM_NAME'	=> $this->language->lang('MOT_HANGMAN'),
									'U_VIEW_FORUM'	=> $this->helper->route('mot_hangman_main_controller'),
								]);

								return $this->helper->render('@mot_hangman/hangman_congrat.html', $this->language->lang('MOT_HANGMAN'));
							}
						}
						else
						{
							$up_points = $this->request->variable('up_points', 0);
						}

						// display message about successful operation
						meta_refresh(4, $this->word_action);
						$message = $this->language->lang('MOT_HANGMAN_WORD_SAVED', $input_points);
						$message .= $up_points > 0 ? '<br>' . $this->language->lang('MOT_HANGMAN_UP_ADDED', $up_points) : '';
						trigger_error($message	. $this->back_link($this->game_action, $this->language->lang('MOT_HANGMAN_TO_GAME'))
												. $this->back_link($this->word_action, $this->language->lang('MOT_HANGMAN_TO_WORD_INPUT'))
												. $this->back_link($this->rank_action, $this->language->lang('MOT_HANGMAN_TO_SCORE_TABLE'))
												. ($this->config['mot_hangman_enable_fame'] ? $this->back_link($this->fame_action, $this->language->lang('MOT_HANGMAN_TO_FAME')) : '')
												. $this->back_link($this->summary_action, $this->language->lang('MOT_HANGMAN_TO_SUMMARY')), E_USER_NOTICE);
					}

					$lc_letters = explode(',', $lc_letters);
					$this->template->assign_vars([
						'MOT_HANGMAN_QUOTE_INPUT_EXPL'	=> $this->language->lang('MOT_HANGMAN_QUOTE_INPUT_EXPL', implode(', ', $letters), $this->config['mot_hangman_punctuation_marks']),
						'MOT_HANGMAN_INPUT_POINTS'		=> $this->language->lang('MOT_HANGMAN_INPUT_POINTS', (int) $input_points),
						'MOT_HANGMAN_LC_LETTERS'		=> json_encode($lc_letters),
						'MOT_HANGMAN_TERM_MIN_LENGTH'	=> $this->config['mot_hangman_term_length'],
						'U_ACTION'						=> $this->u_action . '&amp;action=submit',
					]);
					break;

				case 'rank':
					// set parameter for pagination
					$start = $this->request->is_set('start') ? $this->request->variable('start', 0) : 0;
					$limit = $this->config['mot_hangman_rows_per_page'];	// max lines per page

					// Get total numbers of players in score table
					$count_query = "SELECT COUNT(user_id) AS user_count FROM " . $this->hangman_score_table;
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
					break;

				case 'fame':
					// Get local date variables first
					$date_arr = getdate();
					$number_of_rows = $this->config['mot_hangman_rank_limit'];
					$months_arr = ['', 'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];

					// Get best players of current month
					$sql_arr = [
						'SELECT'	=> 'f.user_id, SUM(f.points) AS points, u.username, u.user_colour',
						'FROM'		=> [$this->hangman_fame_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'f.year = ' . (int) $date_arr['year'] . '
										AND f.month = ' . (int) $date_arr['mon'],
						'GROUP_BY'	=> 'f.user_id',
						'ORDER_BY'	=> 'points DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$players = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$i = 0;
					foreach ($players as $row)
					{
						$this->template->assign_block_vars('current_months', [
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'POINTS'		=> $row['points'],
						]);
						$i++;
						if ($i == $number_of_rows)
						{
							break;
						}
					}

					// Get best players of current year
					$sql_arr = [
						'SELECT'	=> 'f.user_id, f.points, u.username, u.user_colour',
						'FROM'		=> [$this->hangman_fame_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'f.year = ' . (int) $date_arr['year'],
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$players = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					$year_arr = [];
					foreach ($players as $row)
					{
						if (array_key_exists($row['user_id'], $year_arr))
						{
							$year_arr[$row['user_id']]['points'] += $row['points'];
						}
						else
						{
							$year_arr[$row['user_id']] = [
								'points'		=> $row['points'],
								'username'		=> $row['username'],
								'user_colour'	=> $row['user_colour'],
							];
						}
					}
					usort($year_arr,
						function ($item1, $item2)
						{
							return $item2['points'] <=> $item1['points'];
						}
					);

					$i = 0;
					foreach ($year_arr as $row)
					{
						$this->template->assign_block_vars('current_years', [
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'POINTS'		=> $row['points'],
						]);
						$i++;
						if ($i == $number_of_rows)
						{
							break;
						}
					}

					// Get the best payers of the last months
					$sql_arr = [
						'SELECT'	=> 'f.year, f.month, f.user_id, f.points, u.username, u.user_colour',
						'FROM'		=> [$this->hangman_fame_month_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'ORDER_BY'		=> 'f.month_id DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT ' . $number_of_rows;
					$result = $this->db->sql_query($sql);
					$months = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					// Now we can loop through this array and get the player with the most points for the respective months
					foreach ($months as $row)
					{
						$this->template->assign_block_vars('last_months', [
							'MONTH'			=> $this->language->lang($months_arr[$row['month']]) . ' ' . $row['year'],
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'POINTS'		=> $row['points'],
						]);
					}

					// Get data for last years
					$sql_arr = [
						'SELECT'	=> 'f.year, f.user_id, f.points, u.username, u.user_colour',
						'FROM'		=> [$this->hangman_fame_year_table	=> 'f'],
						'LEFT_JOIN'	=> [
							[
								'FROM'	=> [USERS_TABLE	=> 'u'],
								'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'ORDER_BY'		=> 'f.year DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$years = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					foreach ($years as $row)
					{
						$this->template->assign_block_vars('last_years', [
							'YEAR'			=> $row['year'],
							'USERNAME'		=> $row['username'],
							'USER_COLOUR'	=> $row['user_colour'],
							'POINTS'		=> $row['points'],
						]);
					}

					$this->template->assign_vars([
						'MOT_HANGMAN_NUMBER_MONTHS'	=> count($months),
						'MOT_HANGMAN_NUMBER_YEARS'	=> count($years),
					]);
					break;

				case 'summ':
					if ($this->request->is_set('action') && $this->request->variable('action', '') == 'delete')
					{
						$word_id = $this->request->variable('id', 0);
						$term = $this->request->variable('word', '', true);
						if (confirm_box(true))
						{
							$up_points = abs($this->delete_term($word_id));
							meta_refresh(3, $this->summary_action);
							$msg = $this->language->lang('MOT_HANGMAN_TERM_DELETED', $term);
							$msg .= $up_points > 0 ? '<br>' . $this->language->lang('MOT_HANGMAN_UP_SUBTRACTED', $up_points) : '';
							trigger_error($msg . $this->back_link($this->summary_action, $this->language->lang('MOT_HANGMAN_TO_SUMMARY')));
						}
						else
						{
							confirm_box(false, $this->language->lang('MOT_HANGMAN_DELETE_TERM_MSG', $term), build_hidden_fields([
								'u_action'	=> $this->summary_action . '&amp;action=delete&amp;id=' . $word_id . '&amp;word=' . $term,
							]));
						}
					}

					// set parameter for pagination
					$start = $this->request->is_set('start') ? $this->request->variable('start', 0) : 0;
					$limit = $this->config['mot_hangman_rows_per_page'];	// max lines per page

					// Get total number of terms
					$count_query = "SELECT COUNT(word_id) AS term_count FROM " . $this->hangman_words_table;
					$result = $this->db->sql_query($count_query);
					$row = $this->db->sql_fetchrow($result);
					$term_count = $row['term_count'];
					$this->db->sql_freeresult($result);

					$count_query = "SELECT COUNT(word_id) AS term_count FROM " . $this->hangman_words_table . '
									WHERE creator_id = ' . (int) $user_id;
					$result = $this->db->sql_query($count_query);
					$row = $this->db->sql_fetchrow($result);
					$user_term_count = $row['term_count'];
					$this->db->sql_freeresult($result);

					$sql = 'SELECT * FROM ' . $this->hangman_words_table . '
							WHERE creator_id = ' . (int) $user_id;
					$result = $this->db->sql_query_limit( $sql, $limit, $start );
					$user_term = $this->db->sql_fetchrowset($result);
					$this->db->sql_freeresult($result);

					foreach ($user_term as $row)
					{
						$this->template->assign_block_vars('terms', [
							'U_DELETE'				=> $this->summary_action . '&amp;action=delete&amp;id=' . $row['word_id'] . '&amp;word=' . $row['hangman_word'],
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
						'MOT_HANGMAN_EXTRA_POINTS'			=> $this->config['mot_hangman_extra_points_enable'] ? $this->config['mot_hangman_extra_points'] : false,
						'MOT_HANGMAN_POINTS_WORD'			=> $this->config['mot_hangman_points_word'],
						'MOT_HANGMAN_EVADE_ENABLE'			=> $this->config['mot_hangman_evade_enable'] ? $this->language->lang('YES') : $this->language->lang('NO'),
						'MOT_HANGMAN_TERMS_AVAILABLE'		=> $term_count,
						'MOT_HANGMAN_USER_TERMS_AVAILABLE'	=> $user_term_count,
						'ICON_DELETE'						=> '<i class="icon acp-icon acp-icon-delete fa-times-circle fa-fw" title="' . $this->language->lang('DELETE') . '"></i>',
					]);

					$this->language->add_lang('info_acp_mot_hangman', 'mot/hangman');
					break;

			}

			$image_path = append_sid("{$this->ext_path}styles/all/theme/images/hm");
			$pos = strrpos($image_path, '?', 0);
			if ($pos !== false)
			{
				$image_path = substr($image_path, 0, $pos);
			}

			$this->template->assign_vars([
				'MOT_HANGMAN_SHOW_CATEGORY'			=> $this->config['mot_hangman_category_enable'],
				'MOT_HANGMAN_ENFORCE_CATEGORY'		=> $this->config['mot_hangman_category_enforce'],
				'MOT_HANGMAN_ALLOW_TERM_INPUT'		=> $this->auth->acl_get('u_mot_create_search_term'),
				'MOT_HANGMAN_DISPLAY_RANK'			=> $this->config['mot_hangman_enable_rank'],
				'MOT_HANGMAN_DISPLAY_FAME'			=> $this->config['mot_hangman_enable_fame'],
				'MOT_HANGMAN_SELECTED_TAB'			=> $tab,
				'MOT_HANGMAN_TAB_GAME'				=> $this->game_action,
				'MOT_HANGMAN_TAB_WORD'				=> $this->word_action,
				'MOT_HANGMAN_TAB_RANK'				=> $this->rank_action,
				'MOT_HANGMAN_TAB_FAME'				=> $this->fame_action,
				'MOT_HANGMAN_TAB_SUMM'				=> $this->summary_action,
				'MOT_HANGMAN_IMAGE_PATH'			=> $image_path,
				'MOT_HANGMAN_ALLOWED_PUNCT_MARKS'	=> $this->config['mot_hangman_punctuation_marks'],
				'MOT_HANGMAN_ACTIVE'				=> true,
				'MOT_HANGMAN_COPYRIGHT'				=> $this->ext_data['extra']['display-name'] . ' ' . $this->ext_data['version'] . ' &copy; Mike-on-Tour (<a href="' . $this->ext_data['homepage'] . '" target="_blank" rel="noopener">' . $this->ext_data['homepage'] . '</a>)',
			]);

			// Add breadcrumbs link
			$this->template->assign_block_vars('navlinks', [
				'FORUM_NAME'	=> $this->language->lang('MOT_HANGMAN'),
				'U_VIEW_FORUM'	=> $this->helper->route('mot_hangman_main_controller'),
			]);

			return $this->helper->render('@mot_hangman/hangman.html', $this->language->lang('MOT_HANGMAN'));
		}
		else
		{
			trigger_error($this->language->lang('NO_AUTH_OPERATION'));
		}
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
			$sql = 'DELETE FROM ' . $this->hangman_words_table . '
					WHERE ' . $this->db->sql_in_set('word_id', [$word_id]);
			$this->db->sql_query($sql);
		}

		// Update or Insert this user's score
		$user_id = $this->user->data['user_id'];
		$sql_arr = [
			'user_id'	=> $user_id,
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
					WHERE user_id = ' . (int) $user_id;
		}
		else
		{
			$sql_arr = [
				'user_id'		=> $user_id,
				'solve_pts'		=> $game_points,
				'total_pts'		=> $game_points,
				'word_pts'		=> 0,
			];
			$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		}
		$this->db->sql_query($sql);
		$user_ranks = $this->calc_new_ranks($user_id);
		$this->set_ranks();
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
		return '<br><br><a href="' . $u_action . '">&laquo; ' . $lang_str . '</a>';
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

	/**
	* Recalculate the ranks after a player finishes his game to enable comparison with old ranks
	* @param	integer	user_id of the user to check
	*
	* @return	array		array with old and new rank of checked user or empty if this user gained no rank
	*/
	private function calc_new_ranks($user_id)
	{
		$sql = 'SELECT user_id, old_rank FROM ' . $this->hangman_score_table . '
				ORDER BY total_pts DESC';
		$result = $this->db->sql_query($sql);
		$rank_data = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$i = 1;
		$user_ranks = [];
		foreach ($rank_data as $row)
		{
			$sql = 'UPDATE ' . $this->hangman_score_table . '
					SET new_rank = ' . (int) $i . '
					WHERE user_id = ' . (int) $row['user_id'];
			$this->db->sql_query($sql);
			$user_ranks = ((int) $row['user_id'] == (int) $user_id && (int) $row['old_rank'] > $i) ? ['old_rank' => (int) $row['old_rank'], 'new_rank' => $i] : $user_ranks;
			$i++;
		}
		return $user_ranks;
	}

	/**
	* Collect the necessary data and start notifications
	*
	*/
	private function trigger_notification()
	{
		// Check if notifications on loosing a rank is enabled
		if ($this->config['mot_hangman_loose_rank'])
		{
			// Get all users with different new and old rank and their data
			$sql = 'SELECT * FROM ' . $this->hangman_score_table . '
					WHERE old_rank <> new_rank
					ORDER BY total_pts DESC';
			$result = $this->db->sql_query($sql);
			$users = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			// Separate winner and loosers since both are in this array
			$winner = $looser = [];
			foreach ($users as $row)
			{
				if ($row['new_rank'] < $row['old_rank'])
				{
					$winner[] = $row;
				}
				else
				{
					$looser[] = $row;
				}
			}

			// Now check how many winners we have
			switch (count($winner))
			{
				case 1:
					$users_to_notify = [];
					foreach ($looser as $row)
					{
						$users_to_notify[] = $row['user_id'];
					}

					$notification_data = [
						'item_id'			=> $this->config['mot_hangman_rank_lost_id'],
						'winner'			=> $winner[0]['user_id'],
						'users_to_notify'	=> $users_to_notify,
					];
					$this->config->increment('mot_hangman_rank_lost_id', 1, false);
					$this->notification_manager->add_notifications('mot.hangman.notification.type.rank_lost', $notification_data);
					break;

				default:
					// We have either no (very unlikely) or more than one winner (which means that two players simultanously gained a rank) and thus a problem
					break;
			}
		}
	}

	/**
	* Add points to the players account of the current month
	*
	* @param	integer		points to add
	*		bool			add (default) or subtract
	*
	* @return	boolean/float	either false = no UP points credited or float = amount of UP points credited
	*/
	private function save_to_fame($points, $add = true)
	{
		global $phpbb_container;

		// Get local date variables and user id first
		$date_arr = getdate();
		$julian_day = gregoriantojd($date_arr['mon'], $date_arr['mday'], $date_arr['year']);
		$user_id = $this->user->data['user_id'];

		$return = 0;	// Set it to false initially, if points system is activated and UP enabled this will hold the UP points gathered

		// Update or Insert this user's score
		$sql_arr = [
			'year'			=> $date_arr['year'],
			'month'			=> $date_arr['mon'],
			'julian_day'	=> $julian_day,
			'user_id'		=> $user_id,
		];
		$sql = 'SELECT fame_id, points FROM ' . $this->hangman_fame_table . '
				WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$points = $add ? $points : $points * -1;
		if (!empty ($row))
		{
			$sql_arr = [
				'points'		=> $row['points'] + $points,
			];
			$sql = 'UPDATE ' . $this->hangman_fame_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
					WHERE fame_id = ' . (int) $row['fame_id'];
		}
		else
		{
			$sql_arr = [
				'year'			=> $date_arr['year'],
				'month'			=> $date_arr['mon'],
				'julian_day'	=> $julian_day,
				'user_id'		=> $user_id,
				'points'		=> $points,
			];
			$sql = 'INSERT INTO ' . $this->hangman_fame_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		}
		$this->db->sql_query($sql);

		// Check if points system is activated and UP enabled and if yes calculate awarded points into UP points and add to the users account
		if ($this->config['mot_hangman_points_enable'] && $this->phpbb_extension_manager->is_enabled('dmzx/ultimatepoints'))
		{
			$this->functions_points = $phpbb_container->get('dmzx.ultimatepoints.core.functions.points');
			$factor_points = round($this->config['mot_hangman_points_ratio'] * $points, 2);
			$this->functions_points->add_points($user_id, $factor_points);
			$return = $factor_points;
		}

		return $return;
	}

	/**
	* Update the old ranks to the new ranks to ensure a valid base for next storage of points and check for changed ranks
	*
	*/
	private function set_ranks()
	{
		$sql = 'UPDATE ' . $this->hangman_score_table . '
				SET old_rank = new_rank';
		$this->db->sql_query($sql);
	}

	/*
	*
	*
	*
	*/
	private function delete_term($word_id)
	{
		// Remove the term from the HANGMAN_WORDS_TABLE
		$sql = 'DELETE FROM ' . $this->hangman_words_table . ' WHERE word_id = ' . (int) $word_id;
		$this->db->sql_query($sql);

		$points = $this->config['mot_hangman_points_word'];
		// Subtract the word points from the HANGMAN_SCORE_TABLE
		$sql = 'UPDATE ' . $this->hangman_score_table . '
				SET total_pts = total_pts - ' . (int) $points . ', word_pts = word_pts - ' . (int) $points . '
				WHERE user_id = ' . (int) $this->user->data['user_id'];
		$this->db->sql_query($sql);

		// Subtract the word points from the HANGMAN_FAME_TABLE
		$up_points = $this->save_to_fame($points, false);

		// Update the new rankings and get the new rank of current user (false if no better rank gained)
		$user_rank_status = $this->calc_new_ranks($this->user->data['user_id']);

		// Trigger notifications about loosing current rank if applicable
		$this->trigger_notification();

		// All checks are done, now we can set the old ranks to the new ones
		$this->set_ranks();

		return $up_points;
	}

	private function charCodeAt($string, $offset)
	{
	  $string = mb_substr($string, $offset, 1);
	  list(, $ret) = unpack('S', mb_convert_encoding($string, 'UTF-16LE'));
	  return $ret;
	}

	private function encode($str, $key)
	{
		$result = '';
		$len = mb_strlen($str);
		for ($i = 0; $i < $len; $i++)
		{
			$char_code = ($this->charCodeAt($str, $i) + $key) % 256;
			$result .= mb_chr($char_code);
		}
		return $result;
	}
}
