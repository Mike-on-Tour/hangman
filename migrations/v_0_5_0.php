<?php
/**
*
* @package Hangman Game v0.5.0
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\migrations;

class v_0_5_0 extends \phpbb\db\migration\migration
{

	/**
	* Check for migration v_0_4_0 to be installed
	*/
	public static function depends_on()
	{
		return ['\mot\hangman\migrations\v_0_4_0'];
	}

	public function update_data()
	{
		$data = [
			// Add new variables
			['config.add', ['mot_hangman_show_term', 4]],
			['config.add', ['mot_hangman_enforce_term', 0]],
			['config.add', ['mot_hangman_enforce_term_ratio', 40]],

			// Set permission values
			['permission.add', ['u_mot_create_search_term']],
		];

		// Set role permissions
		if ($this->role_exists('ROLE_USER_FULL'))
		{
			$data[] = ['permission.permission_set', ['ROLE_USER_FULL', 'u_mot_create_search_term']];
		}

		if ($this->role_exists('ROLE_USER_STANDARD'))
		{
			$data[] = ['permission.permission_set', ['ROLE_USER_STANDARD', 'u_mot_create_search_term']];
		}

		if ($this->role_exists('ROLE_USER_LIMITED'))
		{
			$data[] = ['permission.permission_set', ['ROLE_USER_LIMITED', 'u_mot_create_search_term']];
		}

		if ($this->role_exists('ROLE_USER_NEW_MEMBER'))
		{
			$data[] = ['permission.permission_set', ['ROLE_USER_NEW_MEMBER', 'u_mot_create_search_term']];
		}

		if ($this->role_exists('ROLE_USER_NOAVATAR'))
		{
			$data[] = ['permission.permission_set', ['ROLE_USER_NOAVATAR', 'u_mot_create_search_term']];
		}

		if ($this->role_exists('ROLE_USER_NOPM'))
		{
			$data[] = ['permission.permission_set', ['ROLE_USER_NOPM', 'u_mot_create_search_term']];
		}

		return $data;
	}

	private function role_exists($role)
	{
		$sql = 'SELECT role_id
			FROM ' . ACL_ROLES_TABLE . "
			WHERE role_name = '" . $this->db->sql_escape($role) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$role_id = $this->db->sql_fetchfield('role_id');
		$this->db->sql_freeresult($result);
		return $role_id;
	}
}
