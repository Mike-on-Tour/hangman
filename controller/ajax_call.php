<?php
/*
*
* @package Hangman v0.2.5
* @author Mike-on-Tour
* @copyright (c) 2021 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace mot\hangman\controller;

class ajax_call
{

	/* @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\user */
	protected $user;

	/** @var string mot.usermap.tables.usermap_users */
	protected $mot_hangman_score_table;

	/** @var string mot.usermap.tables.usermap_poi */
	protected $mot_hangman_words_table;

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request_interface $request,
								\phpbb\user $user, $mot_hangman_score_table, $mot_hangman_words_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
		$this->hangman_score_table = $mot_hangman_score_table;
		$this->hangman_words_table = $mot_hangman_words_table;
	}

	/**
	* Handles cheaters who are trying to evade a loosing game
	*/
	public function ajax_response()
	{
		$game_points = $this->request->variable('score', 0);
		$word_id = $this->request->variable('word_id', 0);

		// Delete the used quote from database (if applicable)
		if ($this->config['mot_hangman_autodelete'])
		{
			$sql_in = array($word_id);
			$sql = 'DELETE FROM ' . $this->hangman_words_table . '
					WHERE ' . $this->db->sql_in_set('word_id', $sql_in);
			$this->db->sql_query($sql);
		}

		// Update or Insert this user's score
		$sql_arr = array(
			'user_id'	=> $this->user->data['user_id'],
		);
		$sql = 'SELECT solve_pts, total_pts FROM ' . $this->hangman_score_table . '
				WHERE ' . $this->db->sql_build_array('SELECT', $sql_arr);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!empty ($row))
		{
			$sql_arr = array(
				'solve_pts'		=> $row['solve_pts'] + $game_points,
				'total_pts'		=> $row['total_pts'] + $game_points,
			);
			$sql = 'UPDATE ' . $this->hangman_score_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
					WHERE user_id = ' . (int) $this->user->data['user_id'];
			$this->db->sql_query($sql);
		}
		else
		{
			$sql_arr = array(
				'user_id'		=> $this->user->data['user_id'],
				'solve_pts'		=> $game_points,
				'total_pts'		=> $game_points,
				'word_pts'		=> 0,
			);
			$sql = 'INSERT INTO ' . $this->hangman_score_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
			$this->db->sql_query($sql);
		}

		$result = [
			'success'	=> true,
		];
		return new \Symfony\Component\HttpFoundation\JsonResponse($result);
	}

}
