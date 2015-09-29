<?php
/**
*
* postoftheday [English]
*
* @package language Top Five
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12mike
* @Swedish translation by Holger (https://www.maskinisten.net)
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
	'POTD_ACP'		=> 'Tillägg Dagens Inlägg',
	'POTD_TITLE'	=> 'Inställningar för tillägget Dagens Inlägg',
	'POTD_VERSION'	=> 'Dagens Inlägg version',
	'POTD_EXT'	    => 'Dagens Inlägg',
	'POTD_CONFIG'	=> 'Inställningar',
	'POTD_SELECT'	=> 'Dagens Inlägg',
	'POTD_SAVED'	=> 'Ändringarna har sparats',
	'POTD_DAY_HOWMANY'	    => 'Antal inlägg idag',
	'POTD_WEEK_HOWMANY'	    => 'Antal inlägg denna vecka',
	'POTD_MONTH_HOWMANY'	=> 'Antal inlägg denna månad',
	'POTD_YEAR_HOWMANY'	    => 'Antal inlägg detta år',
	'POTD_HOWMANY_EXPLAIN'	=> 'Antal inlägg som ska visas. Minimum 1, maximalt 20.',
	'POTD_LOCATION'	        => 'Placering i forumet',
	'POTD_LOCATION_EXPLAIN'	=> 'Var rutan skall visas på forumets startsida.',
	'TOO_SMALL_POTD_HOW_MANY'	=> 'Antalet som skall visas är för litet.',
	'TOO_LARGE_POTD_HOW_MANY'	=> 'Antalet som skall visas är för högt.',
	'TOP_OF_FORUM'	=> 'Längst upp',
	'BOTTOM_OF_FORUM'	=> 'Längst ner',

));
