<?php
/**
*
* @package Hangman Game v0.4.0
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_4_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_3_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_3_0'];
	}

	public function update_data()
	{
		return [
			// Add new variables
			['config.add', ['mot_hangman_term_length', 4]],
			['config.add', ['mot_hangman_rows_per_page', 25]],
		];
	}

}
