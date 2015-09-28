<?php
/**
*
* @package Post of the day
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12Mike
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace v12mike\postoftheday\migrations;

class install_post_of_the_day extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['post_of_the_day_version']) && version_compare($this->config['post_of_the_day_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v312');
	}
	public function update_data()
	{
   //     define('POSTS_LIKES_TABLE',		$this->table_prefix . 'posts_likes');

		return array(
			array('config.add', array('post_of_the_day_how_many', 1)),
			array('config.add', array('post_of_the_day_version', '1.0.0')),
			array('config.add', array('post_of_the_day_location', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'POTD_ACP'
			)),
			array('module.add', array(
				'acp',
				'POTD_ACP',
				array(
					'module_basename'	=> '\v12mike\postoftheday\acp\postoftheday_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('post_of_the_day_how_many')),
			array('config.remove', array('post_of_the_day_version')),
			array('config.remove', array('post_of_the_day_location')),

			array('module.remove', array(
				'acp',
				'POTD_ACP',
				array(
					'module_basename'	=> '\v12mike\postoftheday\acp\postoftheday_module',
					'modes'				=> array('settings'),
				),
			)),
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'POTD_ACP'
			)),
		);
	}
}


	// create an index on post_like timestamp

/*  the following needs fixing
	public function update_schema()
	{
		return array(
            'add_index'		=> array(
                POSTS_LIKES_TABLE			=> array(
                    'timestamp'		=> array('timestamp'),
                    ),
                ),
            );
	}

	public function revert_schema()
	{
		return array(
 			'drop_keys'		=> array(
                POSTS_LIKES_TABLE	=> array('timestamp'),
                ),
            );
	}
*/
//ALTER TABLE `fcf31a_db`.`phpbb_posts_likes` 
//ADD INDEX `idx_phpbb_posts_likes_timestamp` (`timestamp` DESC)  COMMENT '';

//ALTER TABLE `fcf31a_db`.`phpbb_posts_likes` 
//DROP INDEX `idx_phpbb_posts_likes_timestamp` ;

