<?php
/**
*
* @package Hangman v0.8.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace mot\hangman\notification\type;

class mot_hangman_rank_lost extends \phpbb\notification\type\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user_loader */
	protected $user_loader;

	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	* Get notification type name
	*
	* @return	string
	*/
	public function get_type()
	{
		return 'mot.hangman.notification.type.rank_lost';
	}

	/**
	* Notification option data (for outputting to the user)
	*
	* @var	bool|array		False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/
	public static $notification_option = [
		'lang'	=> 'MOT_HANGMAN_NOTIFICATION_TYPE',
		'group'	=> 'MOT_HANGMAN_NOTIFICATION_CATEGORY',
	];

	/**
	* Determines whether this notification type is visible in the UCP notifications settings tab
	*
	* @return	boolean	true = visible / false = invisible
	*/
	public function is_available()
	{
		return $this->config['mot_hangman_loose_rank'];
	}

	/**
	* Returns the value of the item to be checked to be inserted into the NOTIFICATIONS_TABLE as 'item_id'
	*
	* @params		$data		specific data for this notification
	*
	* @return		integer	id of the current round
	*/
	public static function get_item_id($data)
	{
		return $data['item_id'];		// Create a unique id from config variable
	}

	/**
	* Get the id of the parent
	*
	* @params		$data		specific data for this notification
	*
	* @return		integer	id of the item's parent (see function above)
	*/
	public static function get_item_parent_id($data)
	{
		return 0;
	}

	/**
	* Find the users who will receive notifications
	*
	* @params		$data		specific data for this notification
	*			$options	array with options for finding users for this notification
	*
	* @return		array with users to notify
	*/
	public function find_users_for_notification($data, $options = [])
	{
		if (is_null($data['users_to_notify']))
		{
			$data['users_to_notify'] = [];
		}
		$this->user_loader->load_users($data['users_to_notify']);
		return $this->check_user_notification_options($data['users_to_notify'], $options);
	}

	/**
	* Users needed to query before this notification can be displayed
	*
	* @return	array 	users_ids
	*/
	public function users_to_query()
	{
		return [$this->get_data('winner')];
	}

	/**
	* Get the HTML formatted title of this notification
	*
	* @return	string
	*/
	public function get_title()
	{
		return $this->language->lang(
				'MOT_HANGMAN_NOTIFICATION_RANK_LOST',
				$this->user_loader->get_username($this->get_data('winner'), 'no_profile')
		);
	}

	/**
	* Get the url to this item
	*
	* @return	string	URL
	*/
	public function get_url()
	{
		return '';
	}

	/**
	* Get email template
	*
	* @return	string|bool
	*/
	public function get_email_template()
	{
		return '@mot_hangman/mot_hangman_rank_lost';
	}

	/**
	* Get email template variables
	*
	* @return	array
	*/
	public function get_email_template_variables()
	{
		$mail_vars = [
			'WINNER'	=> $this->user_loader->get_username($this->get_data('winner'), 'username'),
		];
		return $mail_vars;
	}

	/**
	* Function for preparing the data for insertion into the 'notification_data' column of the NOTIFICATIONS_TABLE
	* (The service handles insertion)
	*
	* @param	array		$data The data for the new notification
	* 		array		$pre_create_data Data from pre_create_insert_array()
	*
	*/
	public function create_insert_array($data, $pre_create_data = [])
	{
		$this->set_data('item_id', $data['item_id']);
		$this->set_data('winner', $data['winner']);
		$this->set_data('users_to_notify', $data['users_to_notify']);
		parent::create_insert_array($data, $pre_create_data);
	}
}
