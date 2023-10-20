<?php
/**
*
* @package Hangman Game v0.8.0
* @copyright (c) 2021 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_8_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_7_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_7_0'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'mot_hangman_score' => [
					'new_rank'	=> ['UINT:10', 0],
					'old_rank'	=> ['UINT:10', 0],
				],
			],
			'add_tables' => [
				$this->table_prefix . 'mot_hangman_fame' => [
					'COLUMNS'	=> [
						'fame_id'		=> ['UINT:10', null, 'auto_increment'],
						'year'			=> ['UINT:2', 0],
						'month'			=> ['UINT:1', 0],
						'user_id'		=> ['UINT:10', 0],
						'points'		=> ['INT:3', 0],
					],
					'PRIMARY_KEY'	=> 'fame_id',
				],
			],
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['mot_hangman_enable_fame', false]],
			['config.add', ['mot_hangman_gain_rank', false]],
			['config.add', ['mot_hangman_loose_rank', false]],
			['config.add', ['mot_hangman_rank_lost_id', 0, true]],
			['config.add', ['mot_hangman_rank_limit', 3]],
			['custom', [[$this, 'set_ranks']]],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_hangman_fame',
			],
		];
	}

	public function set_ranks()
	{
		$sql = 'SELECT user_id FROM ' . $this->table_prefix . 'mot_hangman_score
				ORDER BY total_pts DESC';
		$result = $this->db->sql_query($sql);
		$rank_data = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$i = 1;
		foreach ($rank_data as $row)
		{
			$sql = 'UPDATE ' . $this->table_prefix . 'mot_hangman_score
					SET new_rank = ' . (int) $i . ', old_rank = ' . (int) $i . '
					WHERE user_id = ' . (int) $row['user_id'];
			$this->db->sql_query($sql);
			$i++;
		}
	}
}
