<?php
/**
*
* @package Hangman Game v0.2.2
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_2_2 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_2_1 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_2_1'];
	}

	public function update_data()
	{
		return [
			// Update the version variable
			['config.update', ['mot_hangman_version', '0.2.2']],
		];
	}
}
