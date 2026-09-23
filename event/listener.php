<?php
/*
*
* @package Hangman v0.13.2
* @copyright (c) 2021 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'				=> 'load_language_on_setup',
			'core.page_header'				=> 'add_page_header_link',
			'core.index_modify_page_title'	=> 'get_visited_page',
			'core.delete_user_after'		=> 'delete_user_after',
			'core.permissions'				=> 'load_permissions',
		];
	}

	public function __construct(
		protected \phpbb\auth\auth $auth,
		protected \phpbb\config\config $config,
		protected \phpbb\db\driver\driver_interface $db,
		protected \phpbb\controller\helper $helper,
		protected \phpbb\language\language $language,
		protected \phpbb\template\template $template,
		protected \phpbb\user $user,
		protected $hangman_fame_table,
		protected $hangman_score_table,
		protected $hangman_fame_month_table,
		protected $hangman_fame_year_table,
	)
	{
	}

	public function load_language_on_setup(object $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'mot/hangman',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link()
	{
		$this->template->assign_vars([
			'U_MOT_HANGMAN'			=> $this->helper->route('mot_hangman_main_controller'),
			'U_MOT_HANGMAN_PLAY'	=> ($this->config['mot_hangman_enable'] && $this->auth->acl_get('u_mot_play_hangman')) || $this->user->data['user_type'] == USER_FOUNDER,
		]);
	}

	/**
	* Get all users playing Hangman from the SESSIONS_TABLE
	*
	*/
	public function get_visited_page()
	{
		$sql_ary = [
			'SELECT'	=> 's.session_user_id, u.username, u.user_colour',

			'FROM'		=> [
				SESSIONS_TABLE	=> 's',
			],

			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [USERS_TABLE	=> 'u'],
					'ON'	=> 'u.user_id = s.session_user_id'
				],
			],

			'WHERE'		=> 	"s.session_page LIKE '%hangman%'
							AND s.session_time >= " . (time() - ($this->config['load_online_time'] * 60)) . '
							AND s.session_user_id <> ' . ANONYMOUS,

			'ORDER_BY'	=> 's.session_user_id ASC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$hangman_users = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$hangman_users_count = $this->language->lang('MOT_HANGMAN_TOTAL_PLAYERS', count($hangman_users));
		$hangman_user_list = '';
		foreach ($hangman_users as $row)
		{
			$hangman_user = '<span style="color: #' . $row['user_colour'] . ';">' . $row['username'] . '</span>';
			$hangman_user_list .= $hangman_user_list != '' ? ', ' . $hangman_user : $hangman_user;
		}

		$this->template->assign_vars([
			'U_MOT_HANGMAN_RANK_LINK'			=> $this->helper->route('mot_hangman_main_controller', ['tab' => 'rank']),
			'S_MOT_HANGMAN_DISPLAY_ONLINE_LIST'	=> $this->config['mot_hangman_display_online'],
			'MOT_HANGMAN_TOTAL_USERS_ONLINE'	=> $hangman_users_count . $hangman_user_list,
		]);
	}

	/**
	* Delete users from the Hangman tables after they were deleted from the users table
	*
	* @params:	mode, retain_username, user_ids, user_rows
	*/
	public function delete_user_after(object $event)
	{
		foreach ($event['user_ids'] as $value)
		{
			// Remove deleted user the highscore
			$sql = 'DELETE FROM ' . $this->hangman_score_table . '
					WHERE user_id = ' . (int) $value;
			$this->db->sql_query($sql);

			// Remove deleted user from the overall fame list
			$sql = 'DELETE FROM ' . $this->hangman_fame_table . '
					WHERE user_id = ' . (int) $value;
			$this->db->sql_query($sql);

			// Remove deleted user from the monthly fame list (before we do this, we get all months for which he was on this list in order to get a replacement, if there was a second one
			$sql = 'SELECT year, month FROM ' . $this->hangman_fame_month_table . '
					WHERE user_id = ' . (int) $value;
			$result = $this->db->sql_query($sql);
			$months = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			// Actually remove the user now
			$sql = 'DELETE FROM ' . $this->hangman_fame_month_table . '
					WHERE user_id = ' . (int) $value;
			$this->db->sql_query($sql);

			// And now we get the replacements (the second best user up to now) and fill them in
			foreach ($months as $row)
			{
				$sql = 'SELECT user_id, SUM(points) AS points FROM ' . $this->hangman_fame_table . '
						WHERE year = ' . (int) $row['year'] . '
						AND month = ' . (int) $row['month'] . '
						GROUP BY user_id
						ORDER BY points DESC
						LIMIT 1';
				$result = $this->db->sql_query($sql);
				$player = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// If there is a second placed user, update their data into the FAME_MONTH_TABLE or delete that line if there is none
				if ($player)
				{
					$sql = 'UPDATE ' . $this->hangman_fame_month_table . ' SET ' . $this->db->sql_build_array('UPDATE', $player) . '
							WHERE year = ' . (int) $row['year'] . '
							AND month = ' . (int) $row['month'];
					$this->db->sql_query($sql);
				}
				else
				{
					$sql = 'DELETE FROM ' . $this->hangman_fame_month_table . '
							WHERE year = ' . (int) $row['year'] . '
							AND month = ' . (int) $row['month'];
					$this->db->sql_query($sql);
				}
			}

			// Remove deleted user from the yearly fame list (before we do this, we get all years for which he was on this list in order to get a replacement, if there was a second one)
			$sql = 'SELECT year FROM ' . $this->hangman_fame_year_table . '
					WHERE user_id = ' . (int) $value;
			$result = $this->db->sql_query($sql);
			$years = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			// Actually remove the user now
			$sql = 'DELETE FROM ' . $this->hangman_fame_year_table . '
					WHERE user_id = ' . (int) $value;
			$this->db->sql_query($sql);

			// And now we get the replacements (the second best user up to now) and fill them in
			foreach ($years as $row)
			{
				$sql = 'SELECT user_id, SUM(points) AS points FROM ' . $this->hangman_fame_table . '
						WHERE year = ' . (int) $row['year'] . '
						GROUP BY user_id
						ORDER BY points DESC
						LIMIT 1';
				$result = $this->db->sql_query($sql);
				$player = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// If there is a second placed user, insert their data into the FAME_YEAR_TABLE or delete that line if there is none
				if ($player)
				{
					$sql = 'UPDATE ' . $this->hangman_fame_year_table . ' SET ' . $this->db->sql_build_array('UPDATE', $player) . '
							WHERE year = ' . (int) $row['year'];
					$this->db->sql_query($sql);
				}
				else
				{
					$sql = 'DELETE FROM ' . $this->hangman_fame_year_table . '
							WHERE year = ' . (int) $row['year'];
					$this->db->sql_query($sql);
				}
			}
		}
	}

	/**
	* Load permissions
	*/
	public function load_permissions(object $event)
	{
		$event->update_subarray('permissions', 'u_mot_play_hangman', ['lang' => 'ACL_U_MOT_HANGMAN_PLAY_HANGMAN', 'cat' => 'misc']);
		$event->update_subarray('permissions', 'u_mot_create_search_term', ['lang' => 'ACL_U_MOT_HANGMAN_CREATE_SEARCH_TERM', 'cat' => 'misc']);
	}
}
