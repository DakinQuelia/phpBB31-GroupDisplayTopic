<?php
/**
*
* @package phpBB Extension - Group Display in viewtopic
* @copyright (c) 2015 Dakin Quelia
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dakinquelia\groupdisplaytopic\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;
	
	/** @var string phpEx */
	protected $php_ext;
	
	static public function getSubscribedEvents()
    {
        return array(
            'core.viewtopic_modify_post_row'				=> 'group_display_topic',
        );
    }
	
	/**
	* Instead of using "global $user;" in the function, we use dependencies again.
	*/
	public function __construct(\phpbb\user $user, $phpbb_root_path, $php_ext)
	{
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}
    
    public function group_display_topic($event)
    {
		// Get the default group name of the poster
		if (!function_exists('get_group_name'))
		{
			include_once($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
		}
		
		$event['post_row'] = array_merge($event['post_row'], array(
			'POSTER_GROUP' => get_group_name($this->user->data['group_id']),
		));
    }
}