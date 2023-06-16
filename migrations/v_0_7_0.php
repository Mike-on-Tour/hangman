<?php
/**
*
* @package Hangman Game v0.7.0
* @copyright (c) 2021 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_7_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_5_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_5_0'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mot_hangman_display_online', true]],
			['config.add', ['mot_hangman_extra_points_enable', false]],
			['config.add', ['mot_hangman_extra_points', 10]],
		];
	}
}
