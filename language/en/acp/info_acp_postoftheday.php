<?php
/**
*
* postoftheday [English]
*
* @package language Top Five
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12mike
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	// ACP
	'POTD_ACP'		=> 'Post of the Day Extension',
	'POTD_TITLE'	=> 'Post of the Day Extension Settings',
	'POTD_VERSION'	=> 'Post of the Day Version',
	'POTD_EXT'	    => 'Post of the Day',
	'POTD_CONFIG'	=> 'Settings',
	'POTD_SELECT'	=> 'Post of the Day',
	'POTD_SAVED'	=> 'Changes Saved',
	'POTD_DAY_HOWMANY'	    => 'How many today posts',
	'POTD_WEEK_HOWMANY'	    => 'How many this week posts',
	'POTD_MONTH_HOWMANY'	=> 'How many this month posts',
	'POTD_YEAR_HOWMANY'	    => 'How many this year posts',
	'POTD_HOWMANY_EXPLAIN'	=> 'How many would you like to display...minimum required is 1, maximum is 20',
	'POTD_LOCATION'	        => 'Location on forum',
	'POTD_LOCATION_EXPLAIN'	=> 'Where do you want the mod to display on the index page',
	'TOO_SMALL_POTD_HOW_MANY'	=> 'The number to display value is too small.',
	'TOO_LARGE_POTD_HOW_MANY'	=> 'The number to display value is too large.',
	'TOP_OF_FORUM'	=> 'Top of Forum',
	'BOTTOM_OF_FORUM'	=> 'Bottom of Forum',

));
