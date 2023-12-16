<?php
/**
*
* @package Hangman v0.9.0
* @copyright (c) 2021 - 2023 Mike-on-Tour
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

	/** @var string mot.hangman.tables.mot_hangman_fame */
	protected $mot_hangman_fame_table;

	/** @var string mot.hangman.tables.mot_hangman_fame */
	protected $mot_hangman_fame_month_table;

	/** @var string mot.hangman.tables.mot_hangman_fame */
	protected $mot_hangman_fame_year_table;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, $mot_hangman_fame_table, $mot_hangman_fame_month_table,
								$mot_hangman_fame_year_table)
	{
		$this->config = $config;
		$this->db = $db;
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

			// It is a new month so we can get the best player of the previous month and store the data into
			$sql = 'SELECT user_id, points FROM ' . $this->hangman_fame_table . '
					WHERE year = ' . (int) $year . '
					AND month = ' . (int) $month . '
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

			// Get best players of last year
			$sql = 'SELECT year, month, user_id, points FROM ' . $this->hangman_fame_table . '
					WHERE year = ' . (int) $current_year;
			$result = $this->db->sql_query($sql);
			$players = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			// If there are results for last year get them and calculate the best player
			if (!empty($players))
			{
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
							'user_id'		=> $row['user_id'],
							'points'		=> $row['points'],
						];
					}
				}
				usort($year_arr,
					function ($item1, $item2)
					{
						return $item2['points'] <=> $item1['points'];
					}
				);

			}

			$best_player = [
				'year'		=> $current_year,
				'user_id'	=> $year_arr[0]['user_id'],
				'points'	=> $year_arr[0]['points'],
			];

			// Save this into the FAME_MONTH_TABLE
			$sql = 'INSERT INTO ' . $this->hangman_fame_year_table . ' ' . $this->db->sql_build_array('INSERT', $best_player);
			$this->db->sql_query($sql);
		}
	}
}
