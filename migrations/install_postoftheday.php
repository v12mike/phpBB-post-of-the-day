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
		return array(
			array('config.add', array('post_of_the_day_how_many', 5)),
			array('config.add', array('post_of_the_day_version', '1.0.0')),
			array('config.add', array('post_of_the_day_location', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'TF_ACP'
			)),
			array('module.add', array(
				'acp',
				'TF_ACP',
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
			array('config.remove', array('post_of_the_day_active')),

			array('module.remove', array(
				'acp',
				'TF_ACP',
				array(
					'module_basename'	=> '\v12mike\postoftheday\acp\postoftheday_module',
					'modes'				=> array('settings'),
				),
			)),
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'TF_ACP'
			)),
		);
	}
}
