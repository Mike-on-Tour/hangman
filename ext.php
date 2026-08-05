<?php
/**
*
* @package Hangman v0.13.0
* @copyright (c) 2021 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace mot\hangman;

class ext extends \phpbb\extension\base
{
	protected $error_message = [];

	protected $php_min_ver = '';
	protected $php_gt = '';
	protected $php_below_ver = '';
	protected $php_lt = '';

	protected $phpbb_min_ver = '';
	protected $phpbb_gt = '';
	protected $phpbb_below_ver = '';
	protected $phpbb_lt = '';

	public function is_enableable()
	{
		// Get the extension's version restrictions
		$this->get_ext_params();

		// Set the language element depending on the phpBB version (3.1.x uses the $user->lang object)
		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0', '<'))
		{
			$language = $this->container->get('user');
			$language->add_lang_ext('mot/hangman', 'mot_hangman_ext_enable_error');
		}
		else
		{
			$language = $this->container->get('language');
			$language->add_lang('mot_hangman_ext_enable_error', 'mot/hangman');
		}
		$ext_name = $language->lang('MOT_HANGMAN_EXT_NAME');

		// Check requirements
		if (!$this->php_requirement())
		{
			$this->error_message[] = $language->lang('MOT_HANGMAN_PHP_VERSION_ERROR', $this->php_min_ver, $this->php_below_ver);
		}

		if (!$this->phpbb_requirement())
		{
			$this->error_message[] = $language->lang('MOT_HANGMAN_ERROR_MESSAGE_PHPBB_VERSION', $this->phpbb_min_ver, $this->phpbb_below_ver);
		}

		if (!empty($this->error_message))
		{
			// Insert general message at the beginning
			array_unshift($this->error_message, $language->lang('MOT_HANGMAN_ERROR_EXTENSION_NOT_ENABLE', $ext_name));
			// phpBB versions before 3.3.0 must use 'trigger_error'
			if (phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<'))
			{
				$this->error_message = implode('<br>', $this->error_message);
				trigger_error($this->error_message, E_USER_WARNING);
			}
		}
		return empty($this->error_message) ? true : $this->error_message;
	}

	protected function php_requirement()
	{
		return phpbb_version_compare(PHP_VERSION, $this->php_min_ver, $this->php_gt) && phpbb_version_compare(PHP_VERSION, $this->php_below_ver, $this->php_lt);
	}

	protected function phpbb_requirement()
	{
		return phpbb_version_compare(PHPBB_VERSION, $this->phpbb_min_ver, $this->phpbb_gt) && phpbb_version_compare(PHPBB_VERSION, $this->phpbb_below_ver, $this->phpbb_lt);
	}

	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('mot.hangman.notification.type.rank_lost');
				return 'notifications';
				break;

			default:
				return parent::enable_step($old_state);
				break;
		}
	}

	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('mot.hangman.notification.type.rank_lost');
				return 'notifications';
				break;

			default:
				return parent::disable_step($old_state);
				break;
		}
	}

	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				try
				{
					$phpbb_notifications = $this->container->get('notification_manager');
					$phpbb_notifications->purge_notifications('mot.hangman.notification.type.rank_lost');
				}
				catch (\phpbb\notification\exception $e)
				{
					// continue
				}

				return 'notifications';
				break;

			default:
				return parent::purge_step($old_state);
				break;
		}
	}

	/*
	* Get the minimum and maximum versions of PHP and phpBB from the composer.json file and set the variables accordingly
	*/
	protected function get_ext_params()
	{
		$metadata_manager = new \phpbb\extension\metadata_manager($this->extension_name, $this->extension_path);
		$metadata = $metadata_manager->get_metadata();

		// Set PHP versions
		$php_versions = html_entity_decode($metadata['require']['php']);
		preg_match("/(?'gt'>=?)(?'min'\d+.\d+(.\d+)?),[ ]?(?'lt'<=?)(?'max'\d+.\d+(.\d+)?(@[a-z]{1,4})?)/", $php_versions, $matches);
		$this->php_min_ver = $matches['min'];
		$this->php_gt = $matches['gt'];
		$this->php_below_ver = $matches['max'];
		$this->php_lt = $matches['lt'];

		// Set phpBB versions
		$phpbb_versions = html_entity_decode($metadata['require']['phpbb/phpbb']);
		preg_match("/(?'gt'>=?)(?'min'\d+.\d+(.\d+)?),[ ]?(?'lt'<=?)(?'max'\d+.\d+(.\d+)?(@[a-z]{1,4})?)/", $phpbb_versions, $matches);
		$this->phpbb_min_ver = $matches['min'];
		$this->phpbb_gt = $matches['gt'];
		$this->phpbb_below_ver = $matches['max'];
		$this->phpbb_lt = $matches['lt'];

		return;
	}
}
