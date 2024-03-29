<?php
/**
*
* @package Hangman Game v0.2.0
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_2_0 extends \phpbb\db\migration\migration
{

	/**
	* If our config variable already exists in the db
	* skip this migration.
	*/
	public function effectively_installed()
	{
		return isset($this->config['mot_hangman_version']);
	}

	public function update_data()
	{
		return [

			// Add the config variable we want to be able to set
			['config.add', ['mot_hangman_lives', 10]],
			['config.add', ['mot_hangman_points_letter', 1]],
			['config.add', ['mot_hangman_points_loose', -5]],
			['config.add', ['mot_hangman_points_win', 15]],
			['config.add', ['mot_hangman_points_word', 8]],
			['config.add', ['mot_hangman_version', '0.2.0']],

			// Add a parent module (ACP_MOT_HANGMAN) to the Extensions tab (ACP_CAT_DOT_MODS)
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MOT_HANGMAN'
			]],

			// Add our settings_module to the parent module (ACP_MOT_HANGMAN)
			['module.add', [
				'acp',
				'ACP_MOT_HANGMAN',
				[
					'module_basename'	=> '\mot\hangman\acp\settings_module',
					'module_langname'	=> 'ACP_MOT_HANGMAN_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'ext_mot/hangman && acl_a_board',
				],
			]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mot_hangman_score'	=> [
					'COLUMNS'	=> [
						'user_id'	=> ['UINT:10', 0],
						'solve_pts'	=> ['INT:11', 0],
						'total_pts'	=> ['INT:11', 0],
						'word_pts'	=> ['INT:11', 0],
					],
					'PRIMARY_KEY'	=> 'user_id',
				],
				$this->table_prefix . 'mot_hangman_words'	=> [
					'COLUMNS'	=> [
						'word_id'				=> ['UINT:10', null, 'auto_increment'],
						'creator_id'			=> ['UINT:10', 0],
						'hangman_word'			=> ['VCHAR:255', ''],
						'hangman_word_hash'		=> ['BINT', 0],
					],
					'PRIMARY_KEY'	=> 'word_id',
					'KEYS'			=> [
						'hangman_word_hash'	=> ['UNIQUE', 'hangman_word_hash'],
					],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'mot_hangman_score',
				$this->table_prefix . 'mot_hangman_words',
			],
		];
	}

}
