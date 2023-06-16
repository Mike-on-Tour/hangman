<?php
/*
*
* @package Hangman v0.7.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2023 Mike-on-Tour
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
			'core.user_setup'				=> 'load_language_on_setup',
			'core.page_header'				=> 'add_page_header_link',
			'core.index_modify_page_title'	=> 'get_visited_page',
			'core.delete_user_after'		=> 'delete_user_after',
			'core.permissions'				=> 'load_permissions',
		];
	}

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

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
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\language\language $language,
								\phpbb\template\template $template, $mot_hangman_score_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->language = $language;
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
		$this->template->assign_var('U_HANGMAN', $this->helper->route('mot_hangman_main_controller'));
	}

	/**
	*
	*
	*/
	public function get_visited_page()
	{
		$sql = 'SELECT s.session_user_id, u.username, u.user_colour FROM ' . SESSIONS_TABLE . ' AS s
				LEFT JOIN ' . USERS_TABLE . " AS u ON (u.user_id = s.session_user_id)
				WHERE s.session_page LIKE '%hangman%'
				ORDER BY s.session_user_id ASC";
		$result = $this->db->sql_query($sql);
		$hangman_users = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$hangman_users_count = $this->language->lang('MOT_HANGMAN_TOTAL_PLAYERS', count($hangman_users));
		$hangman_user_list = '';
		foreach ($hangman_users as $row)
		{
			$hangman_user_list .= $hangman_user_list != '' ? ', <span style="color: #' . $row['user_colour'] . ';">' . $row['username'] . '</span>' : '<span style="color: #' . $row['user_colour'] . ';">' . $row['username'] . '</span>';
		}

		$this->template->assign_vars([
			'S_DISPLAY_HANGMAN_ONLINE_LIST'	=> $this->config['mot_hangman_display_online'],
			'TOTAL_HANGMAN_USERS_ONLINE'	=> $hangman_users_count . $hangman_user_list,
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
