<?php
/**
 * Initialization hook for BYOB
 *
 * @package    Mozilla_BYOB
 * @subpackage hooks
 * @author     l.m.orchard <lorchard@mozilla.com>
 */
class Mozilla_BYOB {

    /**
     * Initialize and wire up event responders.
     */
    public static function init()
    {
        // HACK: Attempt to ensure log file is always group-writable
        @chmod(Kohana::log_directory().date('Y-m-d').'.log'.EXT, 0664);
        
        // Ensure caching varies by cookie (eg. login), browser, and gzip/non-gzip 
        header('Vary: Cookie,User-Agent,Accept-Encoding', true);
    }

}
Event::add('system.ready', array('Mozilla_BYOB', 'init'));
