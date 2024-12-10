<?php
/**
*
* @package Hangman v0.11.0
* @copyright (c) 2021 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\cron\task;

class mot_hangman_reward extends \phpbb\cron\task\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/** @var \mot\hangman\includes\mot_hangman_functions */
	protected $mot_hangman_functions;

	/**
	 * {@inheritdoc
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\extension\manager $phpbb_extension_manager, $mot_hangman_functions)
	{
		$this->config = $config;
		$this->phpbb_extension_manager 	= $phpbb_extension_manager;
		$this->mot_hangman_functions = $mot_hangman_functions;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$this->mot_hangman_functions->check_rewards();

		// Set the last run config variable
		$this->config->set('mot_hangman_reward_last_gc', time());
	}

	/**
	* Returns whether this cron task can run, given current board configuration.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		// Run only if UP is active and rewards are enabled, must not run if UP is deactivated
		return $this->phpbb_extension_manager->is_enabled('dmzx/ultimatepoints') && $this->config['mot_hangman_points_enable'] && $this->config['mot_hangman_reward_enable'];
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between topics tidying is specified in extension
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['mot_hangman_reward_last_gc'] < time() - $this->config['mot_hangman_reward_gc'];
	}
}
