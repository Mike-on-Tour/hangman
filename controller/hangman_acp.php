<?php
/*
*
* @package Hangman v0.4.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace mot\hangman\controller;

class hangman_acp
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\db\tools\tools_interface */
	protected $db_tools;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/** @var \phpbb\log\log $log */
	protected $log;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string mot.hangman.tables.mot_hangman_score */
	protected $mot_hangman_score_table;

	/** @var string mot.hangman.tables.mot_hangman_words */
	protected $mot_hangman_words_table;

	/** @var string mot.hangman.tables.old_hangman_words */
	protected $old_hangman_words_table;

	/**
	 * {@inheritdoc
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\db\tools\tools_interface $db_tools,
								\phpbb\language\language $language, \phpbb\log\log $log, \phpbb\extension\manager $phpbb_extension_manager,
								\phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\user $user, $root_path,
								$mot_hangman_score_table, $mot_hangman_words_table, $old_hangman_words_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->db_tools = $db_tools;
		$this->language = $language;
		$this->log = $log;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->hangman_score_table = $mot_hangman_score_table;
		$this->hangman_words_table = $mot_hangman_words_table;
		$this->old_hangman_words_table = $old_hangman_words_table;

		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/hangman');
		$this->mot_hangman_version = $this->md_manager->get_metadata('version');
	}


	public function settings()
	{
		add_form_key('acp_hangman_settings');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_hangman_settings'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// save the settings to the phpbb_config table
			$this->config->set('mot_hangman_autodelete', $this->request->variable('mot_hangman_autodelete', 0));
			$this->config->set('mot_hangman_category_enable', $this->request->variable('mot_hangman_category_enable', 0));
			$this->config->set('mot_hangman_category_enforce', $this->request->variable('mot_hangman_category_enforce', 0));
			$this->config->set('mot_hangman_evade_enable', $this->request->variable('mot_hangman_evade_enable', 0));
			$this->config->set('mot_hangman_rows_per_page', $this->request->variable('mot_hangman_rows_per_page', 0));
			$this->config->set('mot_hangman_lives', $this->request->variable('acp_hangman_lives', 0));
			$this->config->set('mot_hangman_points_letter', $this->request->variable('acp_hangman_points_letter', 0));
			$this->config->set('mot_hangman_points_loose', $this->request->variable('acp_hangman_points_loose', 0));
			$this->config->set('mot_hangman_points_win', $this->request->variable('acp_hangman_points_win', 0));
			$this->config->set('mot_hangman_points_word', $this->request->variable('acp_hangman_points_word', 0));
			$this->config->set('mot_hangman_term_length', $this->request->variable('acp_hangman_term_length', 0));
			$this->config->set('mot_hangman_punctuation_marks', $this->request->variable('acp_hangman_punctuation_marks', ''));

			trigger_error($this->language->lang('ACP_MOT_HANGMAN_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		if ($this->request->is_set_post('reset_highscore'))
		{
			// Correctly handle empty table
			switch ($this->db->get_sql_layer())
			{
				case 'sqlite3':
					$this->db->sql_query('DELETE FROM ' . $this->hangman_score_table);
				break;

				default:
					$this->db->sql_query('TRUNCATE TABLE ' . $this->hangman_score_table);
				break;
			}

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED');

			if ($this->request->is_ajax())
			{
				trigger_error($this->language->lang('ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'));
			}
		}

		if ($this->request->is_set_post('acp_mot_hangman_upload_file'))
		{
			$file_info = $this->request->file('acp_mot_hangman_file');
			$filename = $file_info['name'];
			$temp_file = $file_info['tmp_name'];

			// Set some variables we will need for checking
			$this->hangman_letters = explode(',', $this->language->lang_raw('MOT_HANGMAN_LETTERS'));
			$this->hangman_punctuation_marks = str_split($this->config['mot_hangman_punctuation_marks']);
			$this->hangman_punctuation_marks[] = ' ';

			// Check for valid file extension
			$path_parts = pathinfo($filename);
			if (strtolower($path_parts['extension']) != 'xml' || !isset($path_parts['extension']))
			{
				trigger_error($this->language->lang('ACP_MOT_HANGMAN_INVALID_FILE_EXT') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// load temp file (no need to store the file somewhere else since we only want the search terms and - if they exist - the category
			$xml = simplexml_load_file($temp_file);
			if ($xml === false)
			{
				trigger_error($this->language->lang('ACP_MOT_HANGMAN_INVALID_FILE_CONTENT') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			else
			{
				$term = [];
				switch ($xml->getName())
				{
					// xml file from " die-muellers.org"
					case 'hangdb':
						foreach ($xml->children() as $row)
						{
							$term[] = [
								'creator_id'		=> $this->user->data['user_id'],
								'hangman_word'		=> str_replace('_', ' ', $row->word),
								'hangman_word_hash'	=> $this->get_hash((string) $row->word),
								'hangman_category'	=> (string) $row->help,
							];
						}
						break;

					case 'wordList':
						foreach ($xml->children() as $difficulty)
						{
							foreach ($difficulty->children() as $category)
							{
								$cat_text = $category['cat'];
								foreach ($category->children() as $word)
								{
									$term[] = [
										'creator_id'		=> $this->user->data['user_id'],
										'hangman_word'		=> (string) $word,
										'hangman_word_hash'	=> $this->get_hash((string) $word),
										'hangman_category'	=> (string) $cat_text,
									];
								}
							}
						}
						break;
				}
				if (!empty($term))
				{
					$i = 0;
					foreach ($term as $term_row)
					{
						if ($this->is_valid_hangman_word($term_row['hangman_word']))
						{
							$sql_arr = [
								'hangman_word_hash'	=> $term_row['hangman_word_hash'],
							];
							$sql = 'SELECT word_id FROM ' . $this->hangman_words_table . '
									WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
							$result = $this->db->sql_query($sql);
							$row = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);

							if (empty($row) && $term_row['hangman_word'] != '')
							{
								// quote doesn't exist, insert it into the table
								$sql_arr = $term_row;
								$sql = 'INSERT INTO ' . $this->hangman_words_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
								$this->db->sql_query($sql);
								$i++;
							}
						}
					}
					trigger_error($this->language->lang('ACP_MOT_HANGMAN_XML_IMPORTED', $i, $filename) . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error($this->language->lang('ACP_MOT_HANGMAN_XML_NO_IMPORT', $filename) . adm_back_link($this->u_action), E_USER_WARNING);
				}
			}
		}

		if ($this->request->is_set_post('acp_mot_hangman_import_table'))
		{
			// Set some variables we will need for checking
			$this->hangman_letters = explode(',', $this->language->lang_raw('MOT_HANGMAN_LETTERS'));
			$this->hangman_punctuation_marks = str_split($this->config['mot_hangman_punctuation_marks']);
			$this->hangman_punctuation_marks[] = ' ';

			// Read all terms from phpbb_hangman_words table
			$sql = 'SELECT user_id, hangman_word, hangman_help FROM ' . $this->old_hangman_words_table;
			$result = $this->db->sql_query($sql);
			$old_hangmans = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			if (isset($old_hangmans) && count($old_hangmans) > 0)
			{
				$i = 0;
				foreach ($old_hangmans as $term)
				{
					$term['hangman_word'] = str_replace('_', ' ', $term['hangman_word']);
					if ($this->is_valid_hangman_word($term['hangman_word']))
					{
						$term['hangman_word_hash'] = $this->get_hash($term['hangman_word']);
						$sql_arr = [
							'hangman_word_hash'	=> $term['hangman_word_hash'],
						];
						$sql = 'SELECT word_id FROM ' . $this->hangman_words_table . '
								WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);

						if (empty($row) && $term['hangman_word'] != '')
						{
							// quote doesn't exist, insert it into the table if 'hangman_word' adheres to the rules defined in the settings
							$sql_arr = [
								'creator_id'		=> $term['user_id'],
								'hangman_word'		=> $term['hangman_word'],
								'hangman_word_hash'	=> $term['hangman_word_hash'],
								'hangman_category'	=> $term['hangman_help'],
							];
							$sql = 'INSERT INTO ' . $this->hangman_words_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
							$this->db->sql_query($sql);
							$i++;
						}
					}
				}
				trigger_error($this->language->lang('ACP_MOT_HANGMAN_TABLE_IMPORTED', $i, $this->old_hangman_words_table) . adm_back_link($this->u_action));
			}
			else
			{
				trigger_error($this->language->lang('ACP_MOT_HANGMAN_TABLE_NO_IMPORT', $this->old_hangman_words_table) . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		$this->template->assign_vars([
			'ACP_MOT_HANGMAN_AUTODELETE'			=> $this->config['mot_hangman_autodelete'],
			'ACP_MOT_HANGMAN_CATEGORY_ENABLE'		=> $this->config['mot_hangman_category_enable'],
			'ACP_MOT_HANGMAN_CATEGORY_ENFORCE'		=> $this->config['mot_hangman_category_enforce'],
			'ACP_MOT_HANGMAN_EVADE_ENABLE'			=> $this->config['mot_hangman_evade_enable'],
			'ACP_MOT_HANGMAN_ROWS_PER_PAGE'			=> $this->config['mot_hangman_rows_per_page'],
			'ACP_MOT_HANGMAN_LIVES'					=> $this->config['mot_hangman_lives'],
			'ACP_MOT_HANGMAN_POINTS_LETTER'			=> $this->config['mot_hangman_points_letter'],
			'ACP_MOT_HANGMAN_POINTS_LOOSE'			=> $this->config['mot_hangman_points_loose'],
			'ACP_MOT_HANGMAN_POINTS_WIN'			=> $this->config['mot_hangman_points_win'],
			'ACP_MOT_HANGMAN_POINTS_WORD'			=> $this->config['mot_hangman_points_word'],
			'ACP_MOT_HANGMAN_TERM_LENGTH'			=> $this->config['mot_hangman_term_length'],
			'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'		=> $this->config['mot_hangman_punctuation_marks'],
			'ACP_MOT_HANGMAN_IMPORT_OLD_TABLE'		=> $this->db_tools->sql_table_exists($this->old_hangman_words_table),
			'U_ACTION'								=> $this->u_action,
			'HANGMAN_VERSION'						=> $this->language->lang('ACP_MOT_HANGMAN_VERSION', $this->mot_hangman_version, date('Y')),
		]);
	}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Set custom form action.
	 *
	 * @param	string	$u_action	Custom form action
	 * @return acp		$this		This controller for chaining calls
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;

		return $this;
	}

	/**
	* Generate a hash value to check for redundant quotes
	* @param	string	original string to get the hash value from
	*
	* @return	integer	hash value with length of string as last digits
	*/
	private function get_hash($original_string)
	{
//		setlocale (LC_CTYPE, 'C');
		return sprintf('%u', crc32(strtolower($original_string))) . strlen($original_string);
	}

	/**
	* Check whether the search term adheres to our rules (no digits, longer than the minimum, no unauthorized punctuation marks)
	* @param	string	search term to be checked
	*
	* @return	boolean	true if term adheres to rules, false if not
	*/
	private function is_valid_hangman_word($hangman_term)
	{
		// check for digits
		if (preg_match('/[0-9]/', $hangman_term, $matches))
		{
			return false;
		}

		// check for unauthorized punctuation marks (MUST check for authorized letters otherwise these would be recognized as invalid marks, this needs multibyte operations in case of "Umlaute")
		$hangman_term = mb_strtoupper($hangman_term, 'UTF-8');
		$len = mb_strlen($hangman_term, 'UTF-8');
		for ($i=0; $i < $len; $i++)
		{
			$char = mb_substr($hangman_term, $i, 1, 'UTF-8');
			if (!in_array($char, $this->hangman_letters) && !in_array($char, $this->hangman_punctuation_marks))
			{
				return false;
			}
		}

		// check for words too short
		if (strlen($hangman_term) < $this->config['mot_hangman_term_length'])
		{
			return false;
		}

		return true;
	}
}
