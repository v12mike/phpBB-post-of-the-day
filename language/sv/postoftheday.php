<?php
/**
*
* @package Post of the day
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12Mike
* @Swedish translation by Holger (https://www.maskinisten.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'POST_OF_THE_DAY'	=> 'Dagens inlägg',
	'NO_TOPIC_EXIST'	=> 'Inga inlägg',
	'IN'                => 'i',
	'BY'                => 'av:',
    'LIKES_TODAY'       => 'Gillat %d gång(er) idag:',
    'LIKES_THIS_WEEK'   => 'Gillat %d gång(er) denna veckan:',
    'LIKES_THIS_MONTH'  => 'Gillat %d gång(er) denna månad:',
    'LIKES_THIS_YEAR'   => 'Gillat %d gång(er) i år:',
));
