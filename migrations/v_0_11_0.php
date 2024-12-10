<?php
/**
*
* @package Hangman Game v0.11.0
* @copyright (c) 2021 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_11_0 extends \phpbb\db\migration\migration
{

	/**
	* Check whether the predecessor migration exists
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_10_0'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'mot_hangman_fame' => [
					'julian_day'	=> ['UINT:10', 0, 'after' => 'month'],
				],
			],
		];
	}

	public function update_data()
	{
		// Get the current date
		$date_arr = getdate();
		$last_reward = ($date_arr['year'] * 10000) + ($date_arr['mon'] * 100) + $date_arr['mday'];

		return [
			['config.add', ['mot_hangman_points_enable', false]],
			['config.add', ['mot_hangman_points_ratio', 0.1]],
			['config.add', ['mot_hangman_reward_enable', false]],
			['config.add', ['mot_hangman_reward_time', 2]],
			['config.add', ['mot_hangman_week_start', 0]],
			['config.add', ['mot_hangman_reward_gc', 3600]],
			['config.add', ['mot_hangman_reward_last_gc', 0, true]],
			['config.add', ['mot_hangman_points_price', 100]],
			['config.add', ['mot_hangman_last_reward', $last_reward, true]],
			['config.add', ['mot_hangman_pm_enable', false]],
			['config.add', ['mot_hangman_admin_id', 0]],
		];
	}

	public function revert_schema()
	{
		return [];
	}

	public function revert_data()
	{
		return [
			['config.remove', ['mot_hangman_points_enable']],
			['config.remove', ['mot_hangman_points_ratio']],
			['config.remove', ['mot_hangman_reward_enable']],
			['config.remove', ['mot_hangman_reward_time']],
			['config.remove', ['mot_hangman_week_start']],
			['config.remove', ['mot_hangman_reward_gc']],
			['config.remove', ['mot_hangman_reward_last_gc']],
			['config.remove', ['mot_hangman_points_price']],
			['config.remove', ['mot_hangman_last_reward']],
			['config.remove', ['mot_hangman_pm_enable']],
			['config.remove', ['mot_hangman_admin_id']],
		];
	}
}
