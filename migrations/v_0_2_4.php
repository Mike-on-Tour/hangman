<?php
/**
*
* @package Hangman Game v0.2.4
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_2_4 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_2_3 to be installed
	*/
	public static function depends_on()
	{
		return array('\mot\hangman\migrations\v_0_2_3');
	}

	public function update_data()
	{
		return array(
			// Update the version variable
			array('config.update', array('mot_hangman_version', '0.2.4')),
			// Change table names in order to prevent chaos resulting from identical table names used by one of dmzx's Hangman Game extensions
			array('custom', array(array($this, 'change_table_names'))),
		);
	}

	public function change_table_names()
	{
		// We do this only if the new tables do not already exist
		if (!$this->db_tools->sql_table_exists($this->table_prefix . 'mot_hangman_score') && !$this->db_tools->sql_table_exists($this->table_prefix . 'mot_hangman_words'))
		{
			// Define table structure
			$score_table_structure = array(
				'COLUMNS'	=> array(
					'user_id'	=> array('UINT:10', 0),
					'solve_pts'	=> array('INT:11', 0),
					'total_pts'	=> array('INT:11', 0),
					'word_pts'	=> array('INT:11', 0),
				),
				'PRIMARY_KEY'	=> 'user_id',
			);
			$word_table_structure = array(
				'COLUMNS'	=> array(
					'word_id'				=> array('UINT:10', null, 'auto_increment'),
					'creator_id'			=> array('UINT:10', 0),
					'hangman_word'			=> array('VCHAR:255', ''),
					'hangman_word_hash'		=> array('BINT', 0),
				),
				'PRIMARY_KEY'	=> 'word_id',
				'KEYS'			=> array(
					'hangman_word_hash'	=> array('UNIQUE', 'hangman_word_hash'),
				),
			);
			// Create new tables
			$this->db_tools->sql_create_table($this->table_prefix . 'mot_hangman_score', $score_table_structure);
			$this->db_tools->sql_create_table($this->table_prefix . 'mot_hangman_words', $word_table_structure);

			// Check whether table 'hangman_score' has our columns
			$score_columns = $this->db_tools->sql_list_columns($this->table_prefix . 'hangman_score');
			if (count ($score_columns) == 4)
			{
				$sql = 'SELECT * FROM ' . $this->table_prefix . 'hangman_score' . '
						ORDER BY user_id';
				$result = $this->db->sql_query($sql);
				$scores = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);
				foreach ($scores as $row)
				{
					$sql_arr = array(
						'user_id'	=> $row['user_id'],
						'solve_pts'	=> $row['solve_pts'],
						'total_pts'	=> $row['total_pts'],
						'word_pts'	=> $row['word_pts'],
					);
					$sql = 'INSERT INTO ' . $this->table_prefix . 'mot_hangman_score' . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
					$this->db->sql_query($sql);
				}
				// Delete old table
				$this->db_tools->sql_table_drop($this->table_prefix . 'hangman_score');
			}

			// Check whether table 'hangman_words' has our columns
			$words_columns = $this->db_tools->sql_list_columns($this->table_prefix . 'hangman_words');
			if (count ($words_columns) == 4)
			{
				$sql = 'SELECT * FROM ' . $this->table_prefix . 'hangman_words' . '
						ORDER BY word_id';
				$result = $this->db->sql_query($sql);
				$words = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);
				foreach ($words as $row)
				{
					$sql_arr = array(
						'creator_id'		=> $row['creator_id'],
						'hangman_word'		=> $row['hangman_word'],
						'hangman_word_hash'	=> $row['hangman_word_hash'],
					);
					$sql = 'INSERT INTO ' . $this->table_prefix . 'mot_hangman_words' . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
					$this->db->sql_query($sql);
				}
				// Delete old table
				$this->db_tools->sql_table_drop($this->table_prefix . 'hangman_words');
			}
		}
	}
}
