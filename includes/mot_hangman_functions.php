<?php
/**
*
* @package Hangman v0.11.0
* @copyright (c) 2021 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\includes;

class mot_hangman_functions
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language $language */
	protected $language;

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

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language, $root_path, $php_ext,
								$mot_hangman_fame_table, $mot_hangman_fame_month_table, $mot_hangman_fame_year_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->hangman_fame_table = $mot_hangman_fame_table;
		$this->hangman_fame_month_table = $mot_hangman_fame_month_table;
		$this->hangman_fame_year_table = $mot_hangman_fame_year_table;
	}

	public function check_month_year()
	{
		// Get the current date
		$date_arr = getdate();
		$current_month = $this->config['mot_hangman_current_month'];

		// Check if we have a new month (it is assumed that at least once a month a player or an admin looks into the game or its settings page to trigger this function)
		if (($date_arr['year'] * 100 + $date_arr['mon']) > $current_month)
		{
			// Save the new current month to the CONFIG_TABLE (we do this as soon as possible to prevent a second call)
			$this->config->set('mot_hangman_current_month', ($date_arr['year'] * 100 + $date_arr['mon']));

			// Get year and month of last maonth
			$year = intdiv($current_month, 100);
			$month = ($current_month % 100);

			// It is a new month so we can get the best player of the previous month and store the data into the FAME_MONTH_TABLE
			$sql = 'SELECT user_id, SUM(points) AS points FROM ' . $this->hangman_fame_table . '
					WHERE year = ' . (int) $year . '
					AND month = ' . (int) $month . '
					GROUP BY user_id
					ORDER BY points DESC
					LIMIT 1';
			$result = $this->db->sql_query($sql);
			$player = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($player)
			{
				$player['year'] = $year;
				$player['month'] = $month;

				// Save this into the FAME_MONTH_TABLE
				$sql = 'INSERT INTO ' . $this->hangman_fame_month_table . ' ' . $this->db->sql_build_array('INSERT', $player);
				$this->db->sql_query($sql);
			}
		}

		// Check if we have a new year
		$current_year = $this->config['mot_hangman_current_year'];
		if ($date_arr['year'] > $current_year)
		{
			// Save the new current year to the CONFIG_TABLE (we do this as soon as possible to prevent a second call)
			$this->config->set('mot_hangman_current_year', $date_arr['year']);

			// Get best player of last year
			$sql = 'SELECT user_id, SUM(points) AS points FROM ' . $this->hangman_fame_table . '
					WHERE year = ' . (int) $current_year . '
					GROUP BY user_id
					ORDER BY points DESC
					LIMIT 1';
			$result = $this->db->sql_query($sql);
			$player = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			// If there are results for last year get them and calculate the best player
			if ($player)
			{
				$player['year'] = $current_year;

				// Save this into the FAME_MONTH_TABLE
				$sql = 'INSERT INTO ' . $this->hangman_fame_year_table . ' ' . $this->db->sql_build_array('INSERT', $player);
				$this->db->sql_query($sql);
			}
		}
	}

	public function check_rewards()
	{
		global $phpbb_container;

		// Get a handle for the function from UP
		$this->functions_points = $phpbb_container->get('dmzx.ultimatepoints.core.functions.points');

		// Get the current date
		$date_arr = getdate();

		// Check if we have a new month
		if (($date_arr['year'] * 100 + $date_arr['mon']) > $this->config['mot_hangman_current_month'])
		{
			// If we do have a new month that means that the listener hasn't run yet, so we must first do the respective actions otherwise the ranking and the hall of fame would not show this
			$this->check_month_year();
		}

		// Get the type of periodic bonus calculation for building the PM to the admin
		$period = $this->config['mot_hangman_reward_time'];

		// Get admin data for PM if PMs are enabled
		if ($this->config['mot_hangman_pm_enable'])
		{
			$sql_arr = [
				'SELECT'	=> 'u.user_id, u.username, s.session_ip',
				'FROM'		=> [
						USERS_TABLE	=> 'u',
				],
				'LEFT_JOIN'	=> [
					[
							'FROM'	=> [SESSIONS_TABLE	=> 's'],
							'ON'	=> 's.session_user_id = u.user_id',
					],
				],
				'WHERE'		=> 'user_id = ' . (int) $this->config['mot_hangman_admin_id'],
			];
			$sql = $this->db->sql_build_query('SELECT', $sql_arr);
			$result = $this->db->sql_query($sql);
			$admin = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			$admin['session_ip'] = $admin['session_ip'] ?? 0;	// Prevent fatal error if IP is null
		}
		$sql = '';	// Reset the query string

		switch ($this->config['mot_hangman_reward_time'])
		{
			// Daily calculation
			case 0:
				// First check whether we need to do this calculation
				if (($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday'] > $this->config['mot_hangman_last_reward'])
				{
					$yesterday = gregoriantojd($date_arr['mon'], $date_arr['mday'], $date_arr['year']) - 1;

					$sql_arr = [
						'SELECT'	=> 'f.user_id, SUM(f.points) AS points, u.username',
						'FROM'		=> [
								$this->hangman_fame_table	=> 'f',
						],
						'LEFT_JOIN'	=> [
							[
									'FROM'	=> [USERS_TABLE	=> 'u'],
									'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> 'julian_day = ' . (int) $yesterday,
						'ORDER_BY'	=> 'points DESC',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT 1';
					$result = $this->db->sql_query($sql);
					$player = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
				}
				break;

			// Weekly calculation
			case 1:
				// First check whether we need to do this calculation
				if ((($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday'] > $this->config['mot_hangman_last_reward']) && ($date_arr['wday'] == (int) $this->config['mot_hangman_week_start']))
				{
					$today = gregoriantojd($date_arr['mon'], $date_arr['mday'], $date_arr['year']);

					$jd_arr = [];
					// Build the array with julian days we need to calculate
					for ($i = 1; $i <= 7; $i++)
					{
						$jd_arr[] = $today - $i;
					}

					$sql_arr = [
						'SELECT'	=> 'f.user_id, SUM(f.points) AS points, u.username',
						'FROM'		=> [
								$this->hangman_fame_table	=> 'f',
						],
						'LEFT_JOIN'	=> [
							[
									'FROM'	=> [USERS_TABLE	=> 'u'],
									'ON'	=> 'u.user_id = f.user_id',
							],
						],
						'WHERE'		=> $this->db->sql_in_set('julian_day', $jd_arr),
						'GROUP_BY'	=> 'f.user_id',
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$sql .= ' LIMIT 1';
					$result = $this->db->sql_query($sql);
					$player = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
				}
				break;

			// Monthly calculation
			case 2:
				$last_calc = intdiv($this->config['mot_hangman_last_reward'], 100);	// Time of last calculation as yyyymm

				// First check whether we need to do this calculation
				if (($date_arr['year'] * 100 + $date_arr['mon']) > $last_calc)
				{
					// Get year and month for the query
					$year = intdiv($last_calc, 100);
					$month = ($last_calc % 100);

					$sql_arr = [
						'SELECT'	=> 'm.user_id, m.points, u.username',
						'FROM'		=> [
								$this->hangman_fame_month_table	=> 'm',
						],
						'LEFT_JOIN'	=> [
							[
									'FROM'	=> [USERS_TABLE	=> 'u'],
									'ON'	=> 'u.user_id = m.user_id',
							],
						],
						'WHERE'		=> 'year = ' . (int) $year . ' AND month = ' . (int) $month,
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$player = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
				}
				break;

			// Yearly calculation
			case 3:
				$last_calc = intdiv($this->config['mot_hangman_last_reward'], 10000);	// Time of last calculation as yyyy

				// First check whether we need to do this calculation
				if ($date_arr['year'] > $last_calc)	// Time of last calculation as yyyy
				{
					$sql_arr = [
						'SELECT'	=> 'y.user_id, y.points, u.username',
						'FROM'		=> [
								$this->hangman_fame_year_table	=> 'y',
						],
						'LEFT_JOIN'	=> [
							[
									'FROM'	=> [USERS_TABLE	=> 'u'],
									'ON'	=> 'u.user_id = y.user_id',
							],
						],
						'WHERE'		=> 'year = ' . (int) $last_calc,
					];
					$sql = $this->db->sql_build_query('SELECT', $sql_arr);
					$result = $this->db->sql_query($sql);
					$player = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
				}
				break;
		}

		if ($sql != '')		// Do we have a valid query string?
		{
			// One of the above checks has been positive and a query has been created hich we can execute now
			$result = $this->db->sql_query($sql);
			$player = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($player)	// Do we have a result?
			{
				$player['up_points'] = round($this->config['mot_hangman_points_ratio'] * $this->config['mot_hangman_points_price'], 2);
				$this->functions_points->add_points($player['user_id'], $player['up_points']);

				// If PMs are enabled send a PM to him and the admin
				if ($this->config['mot_hangman_pm_enable'])
				{
					$this->send_pm(
						$player,
						$this->language->lang('MOT_HANGMAN_WINNER_SUBJECT'),
						$this->language->lang('MOT_HANGMAN_WINNER_MESSAGE_' . $period, $player['username'], $player['points'], $player['up_points'], $admin['username']),
						$admin
					);

					$this->send_pm(
						$admin,
						$this->language->lang('MOT_HANGMAN_ADMIN_SUBJECT_' . $period),
						$this->language->lang('MOT_HANGMAN_ADMIN_MESSAGE', $player['username'], $player['points'], $player['up_points']),
						$admin
					);
				}

				// Save the date of the last run into the CONFIG_TABLE
				$this->config->set('mot_hangman_last_reward', ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday']);
			}
		}
	}

/*
* Private functions ---------------------------------------------------------------------------------------------------------
*/

	/*
	* Function to send a PM
	*
	* @params	array		$recipient		the array holding the information about the recipient
	*		string		$subject		string holding the PM subject
	*		string		$message		string holding the PM message
	*		array		$sender		the array holding the information about the sender
	*/
	private function send_pm($recipient, $subject, $message, $sender)
	{
		if (!function_exists('submit_pm'))
		{
			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
		}

		if (!function_exists('generate_text_for_storage'))
		{
			include($this->root_path . 'includes/functions_content.' . $this->php_ext);
		}

		$uid = $bitfield = $options = '';
		generate_text_for_storage($subject, $uid, $bitfield, $options, false, false, false);
		generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);

		$pm_data = [
			'address_list'		=> ['u' => [$recipient['user_id'] => 'to']],
			'from_user_id'		=> $sender['user_id'],
			'from_username'		=> $sender['username'],
			'icon_id'			=> 0,
			'from_user_ip'		=> $sender['session_ip'],

			'enable_bbcode'		=> true,
			'enable_smilies'	=> true,
			'enable_urls'		=> true,
			'enable_sig'		=> true,

			'message'			=> $message,
			'bbcode_bitfield'	=> $bitfield,
			'bbcode_uid'		=> $uid,
		];
		submit_pm('post', $subject, $pm_data, false);
	}
}
