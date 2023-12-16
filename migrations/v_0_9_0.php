<?php
/**
*
* @package Hangman Game v0.9.0
* @copyright (c) 2021 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_9_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_8_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_8_0'];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'mot_hangman_fame_month' => [
					'COLUMNS'	=> [
						'month_id'		=> ['UINT:10', null, 'auto_increment'],
						'year'			=> ['UINT:2', 0],
						'month'			=> ['UINT:1', 0],
						'user_id'		=> ['UINT:10', 0],
						'points'		=> ['INT:3', 0],
					],
					'PRIMARY_KEY'	=> 'month_id',
				],
				$this->table_prefix . 'mot_hangman_fame_year' => [
					'COLUMNS'	=> [
						'year_id'		=> ['UINT:10', null, 'auto_increment'],
						'year'			=> ['UINT:2', 0],
						'user_id'		=> ['UINT:10', 0],
						'points'		=> ['INT:3', 0],
					],
					'PRIMARY_KEY'	=> 'year_id',
				],
			],
		];
	}

	public function update_data()
	{
		$date_arr = getdate();
		return [
			// Add the config variable we want to be able to set
			['config.add', ['mot_hangman_current_month', ($date_arr['year'] * 100 + $date_arr['mon']), true]],
			['config.add', ['mot_hangman_current_year', $date_arr['year'], true]],
			// Add custom functions
			['custom', [[$this, 'set_fame_months']]],
			['custom', [[$this, 'set_fame_years']]],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_hangman_fame_month',
				$this->table_prefix . 'mot_hangman_fame_year',
			],
		];
	}

	public function revert_data()
	{
		return [
			['config.remove', ['mot_hangman_current_month']],
			['config.remove', ['mot_hangman_current_year']],
		];
	}

	public function set_fame_months()
	{
		$date_arr = getdate();
		$best_players = [];
		// Get the last 10 months including their year (if the counting goes backwards over a year change) and store it in an array for further usage
		$months = [];
		for ($j = 1; $j <= 10; $j++)
		{
			$date_mon = $date_arr['mon'] - $j;
			$date_year = $date_arr['year'];
			if ($date_mon <= 0)
			{
				$date_mon += 12;
				$date_year--;
			}
			$months[] = [
				'mon'	=> $date_mon,
				'year'	=> $date_year,
			];
		}

		// Now we can loop through this array and get the player with the most points for the respective months
		foreach ($months as $row)
		{
			$sql = 'SELECT user_id, points FROM ' . $this->table_prefix . 'mot_hangman_fame
					WHERE year = ' . (int) $row['year'] . '
					AND month = ' . (int) $row['mon'] . '
					ORDER BY points DESC
					LIMIT 1';
			$result = $this->db->sql_query($sql);
			$player = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!empty($player))
			{
				$best_players[] = [
					'year'		=> $row['year'],
					'month'		=> $row['mon'],
					'user_id'	=> $player['user_id'],
					'points'	=> $player['points'],
				];
			}
		}

		$best_players = array_reverse($best_players);
		$this->db->sql_multi_insert($this->table_prefix . 'mot_hangman_fame_month', $best_players);
	}

	public function set_fame_years()
	{
		$current_year = date('Y');
		$best_players = [];
		$years = [];

		// Get former years
		$sql = 'SELECT DISTINCT year FROM ' . $this->table_prefix . 'mot_hangman_fame
				WHERE year < ' . (int) $current_year . '
				ORDER BY year ASC';
		$result = $this->db->sql_query_limit($sql, 10, 0);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$years[] = $row['year'];
		}
		$this->db->sql_freeresult($result);

		foreach ($years as $year_row)
		{
			// Get best players of each year
			$sql = 'SELECT year, month, user_id, points FROM ' . $this->table_prefix . 'mot_hangman_fame
					WHERE year = ' . (int) $year_row;
			$result = $this->db->sql_query($sql);
			$players = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

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

				$best_players[] = [
					'year'		=> $year_row,
					'user_id'	=> $year_arr[0]['user_id'],
					'points'	=> $year_arr[0]['points'],
				];
			}
		}

		$this->db->sql_multi_insert($this->table_prefix . 'mot_hangman_fame_year', $best_players);
	}
}
