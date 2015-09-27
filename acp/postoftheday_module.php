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
		$this->page_title = $user->lang['POTD_EXT'];
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

			$check_row = array('post_of_the_day_how_many_today' => $request->variable('post_of_the_day_how_many_today', 0));
			$validate_row = array('post_of_the_day_how_many_today' => array('num', false, 0, 20));
			$error = validate_data($check_row, $validate_row);

			// Replace "error" strings with their real, localised form
			$error = array_map(array($user, 'lang'), $error);

			if (!sizeof($error))
            {
                $check_row = array('post_of_the_day_how_many_this_week' => $request->variable('post_of_the_day_how_many_this_week', 0));
                $validate_row = array('post_of_the_day_how_many_this_week' => array('num', false, 0, 20));
                $error = validate_data($check_row, $validate_row);

                // Replace "error" strings with their real, localised form
                $error = array_map(array($user, 'lang'), $error);
            }
			if (!sizeof($error))
            {
                $check_row = array('post_of_the_day_how_many_this_month' => $request->variable('post_of_the_day_how_many_this_month', 0));
                $validate_row = array('post_of_the_day_how_many_this_month' => array('num', false, 0, 20));
                $error = validate_data($check_row, $validate_row);

                // Replace "error" strings with their real, localised form
                $error = array_map(array($user, 'lang'), $error);
            }
			if (!sizeof($error))
            {
                $check_row = array('post_of_the_day_how_many_this_year' => $request->variable('post_of_the_day_how_many_this_year', 0));
                $validate_row = array('post_of_the_day_how_many_this_year' => array('num', false, 0, 20));
                $error = validate_data($check_row, $validate_row);

                // Replace "error" strings with their real, localised form
                $error = array_map(array($user, 'lang'), $error);
            }

			if (!sizeof($error))
			{
				$config->set('post_of_the_day_how_many_today',      $request->variable('post_of_the_day_how_many_today', 0));
				$config->set('post_of_the_day_how_many_this_week',  $request->variable('post_of_the_day_how_many_this_week', 0));
				$config->set('post_of_the_day_how_many_this_month', $request->variable('post_of_the_day_how_many_this_month', 0));
				$config->set('post_of_the_day_how_many_this_year',  $request->variable('post_of_the_day_how_many_this_year', 0));
				$config->set('post_of_the_day_location',            $request->variable('post_of_the_day_location', true));

				trigger_error($user->lang['POTD_SAVED'] . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars(array(
			'POTD_ERROR'	        => isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
			'HOWMANY_TODAY'			=> (!empty($this->config['post_of_the_day_how_many_today'])) ? $this->config['post_of_the_day_how_many_today'] : 0,
			'HOWMANY_THIS_WEEK'		=> (!empty($this->config['post_of_the_day_how_many_this_week'])) ? $this->config['post_of_the_day_how_many_this_week'] : 0,
			'HOWMANY_THIS_MONTH'	=> (!empty($this->config['post_of_the_day_how_many_this_month'])) ? $this->config['post_of_the_day_how_many_this_month'] : 0,
			'HOWMANY_THIS_YEAR'		=> (!empty($this->config['post_of_the_day_how_many_this_year'])) ? $this->config['post_of_the_day_how_many_this_year'] : 0,
			'LOCATION'			=> (!empty($this->config['post_of_the_day_location'])) ? true : false,
			'POTD_VERSION'		=> $this->config['post_of_the_day_version'],

			'U_ACTION'			=> $this->u_action,
		));
	}
}
