<?php
/**
*
* @package Post of the Day
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12Mike
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace v12mike\postoftheday\acp;

class postoftheday_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$this->config = $config;
		$this->request = $request;

		$user->add_lang('acp/common');
		$user->add_lang_ext('v12mike/postoftheday', 'acp/info_acp_postoftheday');
		$this->tpl_name = 'acp_postoftheday';
		$this->page_title = $user->lang['POSTOFTHEDAY_EXT'];
		add_form_key('acp_postoftheday');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_postoftheday'))
			{
				trigger_error('FORM_INVALID');
			}
			if (!function_exists('validate_data'))
			{
				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
			}

			$check_row = array('post_of_the_day_how_many' => $request->variable('post_of_the_day_how_many', 0));
			$validate_row = array('post_of_the_day_how_many' => array('num', false, 1, 20));
			$error = validate_data($check_row, $validate_row);

			// Replace "error" strings with their real, localised form
			$error = array_map(array($user, 'lang'), $error);

			if (!sizeof($error))
			{
				$config->set('post_of_the_day_how_many', $request->variable('post_of_the_day_how_many', 0));
			//	$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
			//	$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
			//	$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
				$config->set('post_of_the_day_location', $request->variable('post_of_the_day_location', true));
			//	$config->set('top_five_active', $request->variable('top_five_active', true));

			//	$cache->destroy('_top_five_newest_users');
			//	$cache->destroy('_top_five_posters');

				trigger_error($user->lang['POTD_SAVED'] . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars(array(
			'POTD_ERROR'	    => isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
			'HOWMANY'			=> (!empty($this->config['post_of_the_day_how_many'])) ? $this->config['post_of_the_day_how_many'] : 0,
		//	'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
		//	'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
		//	'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
			'LOCATION'			=> (!empty($this->config['post_of_the_day_location'])) ? true : false,
		//	'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
			'TF_VERSION'		=> $this->config['post_of_the_day_version'],

			'U_ACTION'			=> $this->u_action,
		));
	}
}
