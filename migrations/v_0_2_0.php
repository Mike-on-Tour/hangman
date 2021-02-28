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
		return array(

			// Add the config variable we want to be able to set
			array('config.add', array('mot_hangman_lives', 10)),
			array('config.add', array('mot_hangman_points_letter', 1)),
			array('config.add', array('mot_hangman_points_loose', -5)),
			array('config.add', array('mot_hangman_points_win', 15)),
			array('config.add', array('mot_hangman_points_word', 8)),
			array('config.add', array('mot_hangman_version', '0.2.0')),

			// Add a parent module (ACP_HANGMAN) to the Extensions tab (ACP_CAT_DOT_MODS)
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_HANGMAN'
			)),

			// Add our settings_module to the parent module (ACP_HANGMAN)
			array('module.add', array(
				'acp',
				'ACP_HANGMAN',
				array(
					'module_basename'	=> '\mot\hangman\acp\settings_module',
					'module_langname'	=> 'ACP_HANGMAN_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'ext_mot/hangman && acl_a_board',
				),
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'hangman_score'	=> array(
					'COLUMNS'	=> array(
						'user_id'	=> array('UINT:10', 0),
						'solve_pts'	=> array('INT:11', 0),
						'total_pts'	=> array('INT:11', 0),
						'word_pts'	=> array('INT:11', 0),
					),
					'PRIMARY_KEY'	=> 'user_id',
				),
				$this->table_prefix . 'hangman_words'	=> array(
					'COLUMNS'	=> array(
						'word_id'				=> array('UINT:10', null, 'auto_increment'),
						'creator_id'			=> array('UINT:10', 0),
						'hangman_word'			=> array('VCHAR:255', ''),
//						'hangman_word_clean'	=> array('VCHAR:255', ''),
						'hangman_word_hash'		=> array('BINT', 0),
					),
					'PRIMARY_KEY'	=> 'word_id',
					'KEYS'			=> array(
						'hangman_word_hash'	=> array('UNIQUE', 'hangman_word_hash'),
					),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'hangman_score',
				$this->table_prefix . 'hangman_words',
			),
		);
	}

}
