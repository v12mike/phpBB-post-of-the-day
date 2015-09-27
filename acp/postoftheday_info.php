<?php
/**
*
* @package Post of the day
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12Mike
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace v12mike\postoftheday\acp;

/**
* @package module_install
*/
class postoftheday_info
{
	function module()
	{
		return array(
			'filename'	=> '\v12mike\postoftheday\acp\postoftheday_module',
			'title'		=> 'Post of the day',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'POTD_CONFIG', 'auth'	=> 'ext_v12mike/postoftheday', 'cat'	=> array('POTD_EXT')),
			),
		);
	}
}
