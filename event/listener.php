<?php
/**
*
* @package Post of the day
* @copyright (c) 2014 RMcGirr83, (c) 2015 v12Mike
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace v12mike\postoftheday\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
    /** @var \v12mike\postoftheday\core\postoftheday */
	protected $functions;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	public function __construct(\v12mike\postoftheday\core\postoftheday $functions, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->functions = $functions;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{

		return array(
			'core.index_modify_page_title'	=> 'main',
		);
	}

	public function main($event)
	{
		// add lang file
		$this->user->add_lang_ext('v12mike/postoftheday', 'postoftheday');

		$this->functions->topposts();

		$this->template->assign_vars(array(
			'S_POSTOFTHEDAY_LOCATION'	=> $this->config['post_of_the_day_location'],
		));
	}
}
