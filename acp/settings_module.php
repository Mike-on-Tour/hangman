<?php
/**
*
* @package Hangman Game v0.3.0
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\acp;

class settings_module
{
	public $u_action;

	public function main()
	{
		global $config, $db, $phpbb_container, $phpbb_log, $request, $template, $user, $phpbb_root_path, $table_prefix;

		$language = $phpbb_container->get('language');
		$this->md_manager = $phpbb_container->get('ext.manager')->create_extension_metadata_manager('mot/hangman');
		$this->tpl_name = 'acp_hangman_settings';
		$this->page_title = $language->lang('ACP_MOT_HANGMAN');

		add_form_key('acp_hangman_settings');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_hangman_settings'))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// save the settings to the phpbb_config table
			$config->set('mot_hangman_autodelete', $request->variable('mot_hangman_autodelete', 0));
			$config->set('mot_hangman_category_enable', $request->variable('mot_hangman_category_enable', 0));
			$config->set('mot_hangman_category_enforce', $request->variable('mot_hangman_category_enforce', 0));
			$config->set('mot_hangman_evade_enable', $request->variable('mot_hangman_evade_enable', 0));
			$config->set('mot_hangman_lives', $request->variable('acp_hangman_lives', 0));
			$config->set('mot_hangman_points_letter', $request->variable('acp_hangman_points_letter', 0));
			$config->set('mot_hangman_points_loose', $request->variable('acp_hangman_points_loose', 0));
			$config->set('mot_hangman_points_win', $request->variable('acp_hangman_points_win', 0));
			$config->set('mot_hangman_points_word', $request->variable('acp_hangman_points_word', 0));
			$config->set('mot_hangman_punctuation_marks', $request->variable('acp_hangman_punctuation_marks', ''));

			trigger_error($language->lang('ACP_MOT_HANGMAN_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		if ($request->is_set_post('reset_highscore'))
		{
			define ('HANGMAN_SCORE_TABLE', $table_prefix . 'mot_hangman_score');

			// Correctly handle empty table
			switch ($db->get_sql_layer())
			{
				case 'sqlite3':
					$db->sql_query('DELETE FROM ' . HANGMAN_SCORE_TABLE);
				break;

				default:
					$db->sql_query('TRUNCATE TABLE ' . HANGMAN_SCORE_TABLE);
				break;
			}

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED');

			if ($request->is_ajax())
			{
				trigger_error($language->lang('ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'));
			}
		}

		$mot_hangman_version = $this->md_manager->get_metadata('version');
		$template->assign_vars(array(
			'ACP_MOT_HANGMAN_AUTODELETE'			=> $config['mot_hangman_autodelete'],
			'ACP_MOT_HANGMAN_CATEGORY_ENABLE'		=> $config['mot_hangman_category_enable'],
			'ACP_MOT_HANGMAN_CATEGORY_ENFORCE'		=> $config['mot_hangman_category_enforce'],
			'ACP_MOT_HANGMAN_EVADE_ENABLE'			=> $config['mot_hangman_evade_enable'],
			'ACP_MOT_HANGMAN_LIVES'					=> $config['mot_hangman_lives'],
			'ACP_MOT_HANGMAN_POINTS_LETTER'			=> $config['mot_hangman_points_letter'],
			'ACP_MOT_HANGMAN_POINTS_LOOSE'			=> $config['mot_hangman_points_loose'],
			'ACP_MOT_HANGMAN_POINTS_WIN'			=> $config['mot_hangman_points_win'],
			'ACP_MOT_HANGMAN_POINTS_WORD'			=> $config['mot_hangman_points_word'],
			'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'		=> $config['mot_hangman_punctuation_marks'],
			'U_ACTION'								=> $this->u_action,
			'HANGMAN_VERSION'						=> $language->lang('ACP_MOT_HANGMAN_VERSION', $mot_hangman_version, date('Y')),
			'ICON_PAYPAL'							=> '<img src="' . $phpbb_root_path . 'ext/mot/hangman/adm/images/Paypal.svg" />',
		));
	}

}
