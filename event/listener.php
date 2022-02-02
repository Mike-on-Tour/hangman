<?php
/*
*
* @package Hangman v0.5.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'			=> 'load_language_on_setup',
			'core.page_header'			=> 'add_page_header_link',
			'core.delete_user_after'	=> 'delete_user_after',
			'core.permissions'			=> 'load_permissions',
		];
	}

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/** @var string mot.usermap.tables.usermap_users */
	protected $mot_hangman_score_table;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper	Controller helper object
	* @param \phpbb\template		$template	Template object
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\template\template $template,
								$mot_hangman_score_table)
	{
		$this->db = $db;
		$this->helper = $helper;
		$this->template = $template;
		$this->hangman_score_table = $mot_hangman_score_table;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'mot/hangman',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link()
	{
		$this->template->assign_vars([
			'U_HANGMAN'	=> $this->helper->route('mot_hangman_main_controller'),
		]);
	}

	/**
	* Delete a user from mot_hangman_score table after he was deleted from the users table
	*
	* @params:	mode, retain_username, user_ids, user_rows
	*/
	public function delete_user_after($event)
	{
		// get the user_id's stored in an indexed array
		$user_id_ary = $event['user_ids'];
		// if user(s) got deleted we need to delete them from mot_hangman_score table
		foreach ($user_id_ary as $value)
		{
			$sql = 'DELETE FROM ' . $this->hangman_score_table . '
					WHERE user_id = ' . (int) $value;
			$this->db->sql_query($sql);
		}
	}

	/**
	* Load permissions
	*/
	public function load_permissions($event)
	{
		$event->update_subarray('permissions', 'u_mot_create_search_term', ['lang' => 'ACL_U_MOT_HANGMAN_CREATE_SEARCH_TERM', 'cat' => 'misc']);
	}
}
