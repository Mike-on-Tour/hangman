<?php
/**
*
* @package Hangman Game v0.2.0
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
		global $config, $phpbb_container, $request, $template, $phpbb_root_path;

		$language = $phpbb_container->get('language');
		$this->tpl_name = 'acp_hangman_settings';
		$this->page_title = $language->lang('ACP_HANGMAN');

		add_form_key('acp_hangman_settings');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_hangman_settings'))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// save the settings to the phpbb_config table
			$config->set('mot_hangman_lives', $request->variable('acp_hangman_lives', 0));
			$config->set('mot_hangman_points_letter', $request->variable('acp_hangman_points_letter', 0));
			$config->set('mot_hangman_points_loose', $request->variable('acp_hangman_points_loose', 0));
			$config->set('mot_hangman_points_win', $request->variable('acp_hangman_points_win', 0));
			$config->set('mot_hangman_points_word', $request->variable('acp_hangman_points_word', 0));

			trigger_error($language->lang('ACP_HANGMAN_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'ACP_HANGMAN_LIVES'					=> $config['mot_hangman_lives'],
			'ACP_HANGMAN_POINTS_LETTER'			=> $config['mot_hangman_points_letter'],
			'ACP_HANGMAN_POINTS_LOOSE'			=> $config['mot_hangman_points_loose'],
			'ACP_HANGMAN_POINTS_WIN'			=> $config['mot_hangman_points_win'],
			'ACP_HANGMAN_POINTS_WORD'			=> $config['mot_hangman_points_word'],
			'U_ACTION'							=> $this->u_action . '&amp;action=submit',
			'HANGMAN_VERSION'					=> $config['mot_hangman_version'],
			'HANGMAN_YEAR'						=> date('Y'),
			'ICON_PAYPAL'						=> '<img src="' . $phpbb_root_path . 'ext/mot/hangman/adm/images/Paypal.svg" />',
		));
	}

}
