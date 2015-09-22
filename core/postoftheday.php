<?php

/**
*
* @package Post of the Day
* @copyright (c) 2015 V12Mike
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*
*/

namespace v12mike\postoftheday\core;

class postoftheday
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\content_visibility */
	protected $content_visibility;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string PHP extension */
	protected $php_ext;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->cache = $cache;
		$this->content_visibility = $content_visibility;
		$this->db = $db;
		$this->dispatcher = $dispatcher;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	public function topposts($tpl_loopname = 'post_of_the_day')
	{

	//	$howmany = $this->howmany();
		$howmany = 1;

		$forum_ary = array();
		$forum_read_ary = $this->auth->acl_getf('f_read');

		foreach ($forum_read_ary as $forum_id => $allowed)
		{
			if ($allowed['f_read'])
			{
				$forum_ary[] = (int) $forum_id;
			}
		}
		$forum_ary = array_unique($forum_ary);

		if (sizeof($forum_ary))
		{
			/**
			* Select post_ids
			*/
define('POSTS_LIKES_TABLE',				'phpbb_posts_likes');

            // find all the visible, liked posts in the given period
                $sql = 'SELECT '. USERS_TABLE . '.user_id, '. USERS_TABLE . '.username, '. USERS_TABLE . '.user_colour, ' . TOPICS_TABLE . '.topic_title, ' . TOPICS_TABLE . '.forum_id, ' . TOPICS_TABLE . '.topic_id, ' . POSTS_TABLE . '.post_id, ' . POSTS_TABLE . '.post_time, ' . TOPICS_TABLE . '.topic_last_poster_name, ' . TOPICS_TABLE . '.topic_type, ' . FORUMS_TABLE . '.forum_name, sum_likes 
                    FROM ( 
                        SELECT post_id AS post, COUNT(*) AS sum_likes
                        FROM ' . POSTS_LIKES_TABLE . ' 
                        WHERE ' . POSTS_LIKES_TABLE . '.timestamp > 50
                        GROUP BY post_id 
                        ORDER BY sum_likes DESC
                ) AS liked_posts
                LEFT JOIN ' . POSTS_TABLE .   ' ON post = post_id
                LEFT JOIN ' . TOPICS_TABLE .  ' ON ' . POSTS_TABLE .  '.topic_id = '  . TOPICS_TABLE . '.topic_id
                LEFT JOIN ' . USERS_TABLE .   ' ON ' . POSTS_TABLE .  '.poster_id = ' . USERS_TABLE .  '.user_id
                LEFT JOIN ' . FORUMS_TABLE .  ' ON ' . TOPICS_TABLE . '.topic_id = '  . FORUMS_TABLE . '.forum_id
				WHERE  ' . $this->content_visibility->get_forums_visibility_sql('post', $forum_ary, POSTS_TABLE .'.') . '
				AND topic_status <> ' . ITEM_MOVED . '
                ORDER BY sum_likes DESC, ' . POSTS_TABLE . '.post_time DESC';

            // cache the query for one minute 
			$result = $this->db->sql_query_limit($sql, $howmany, 0, 60);
			$forums = $ga_topic_ids = $topic_ids = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$topic_ids[] = $row['topic_id'];
				if ($row['topic_type'] == POST_GLOBAL)
				{
					$ga_topic_ids[] = $row['topic_id'];
				}
				else
				{
					$forums[$row['forum_id']][] = $row['topic_id'];
				}
			}

			// Get topic tracking
			$topic_tracking_info = array();
			foreach ($forums as $forum_id => $topic_id)
			{
				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
			}

            $this->db->sql_rowseek(0, $result);
            while ($row = $this->db->sql_fetchrow($result))
            {
                $topic_id = $row['topic_id'];
                $forum_id = $row['forum_id'];
                $forum_name = $row['forum_name'];

                $post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
                $view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '&amp;p=' . $row['post_id'] . '#p' . $row['post_id']);
                $forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
                $topic_title = censor_text($row['topic_title']);
                if (utf8_strlen($topic_title) >= 60)
                {
                    $topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
                }
                $is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;

                $tpl_ary = array(
                    'U_TOPIC'			=> $view_topic_url,
                    'U_FORUM'			=> $forum_name_url,
                    'S_UNREAD'			=> ($post_unread) ? true : false,
                    'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
                    'LAST_TOPIC_TIME'	=> $this->user->format_date($row['post_time']),
                    'TOPIC_TITLE' 		=> $topic_title,
                    'FORUM_NAME'		=> $forum_name,
                    'POST_LIKES'        => $row['sum_likes'],
                );
                /**
                * Modify the topic data before it is assigned to the template
                *
                * @event rmcgirr83.topfive.modify_tpl_ary
                * @var	array	row			Array with topic data
                * @var	array	tpl_ary		Template block array with topic data
                * @since 1.0.0
                */
                $vars = array('row', 'tpl_ary');
                extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));

                $this->template->assign_block_vars($tpl_loopname, $tpl_ary);
            }
            $this->db->sql_freeresult($result);
		}
		else
		{
			$this->template->assign_block_vars($tpl_loopname, array(
				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
			));
		}
	}


//	private function howmany()
//	{
//		$howmany = $this->config['top_five_how_many'];

//		return (int) $howmany;
//	}
}
