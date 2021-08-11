<?php
/**
*
* @package Hangman Game v0.3.0
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_3_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_2_5 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_2_5'];
	}

	public function update_data()
	{
		return [
			// Update the version variable
			['config.update', ['mot_hangman_version', '0.3.0']],
			// Add new variables
			['config.add', ['mot_hangman_autodelete', '1']],
			['config.add', ['mot_hangman_category_enable', '0']],
			['config.add', ['mot_hangman_category_enforce', '0']],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'mot_hangman_words' => [
					'hangman_category'	=> ['VCHAR:255', ''],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'mot_hangman_words' => [
					'hangman_category',
				],
			],
		];
	}

}
