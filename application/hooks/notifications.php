<?php
/**
 * Repack state change notifications hook
 *
 * @package    Mozilla_BYOB_RepackNotifications
 * @subpackage hooks
 * @author     l.m.orchard <lorchard@mozilla.com>
 */
class Mozilla_BYOB_RepackNotifications {

    public static $notification_states = array(
        'requested', 'canceled', 'started', 'failed', 
        'pending', 'released', 'rejected', 'reverted', 
    );


    /**
     * Initialize and wire up event responders.
     */
    public static function init()
    {
        // Respond to repack state changes
        Event::add(
            "BYOB.repack.changeState",
            array(get_class(), 'handleStateChange')
        );
    }

    /**
     * Dispatcher for repack state change events.
     */
    public static function handleStateChange()
    {
        if (!Kohana::config('repacks.enable_notifications')) return;

        if (!in_array(Event::$data['new_state'], self::$notification_states)) {
            return;
        }

        $repack = ORM::factory('repack')
            ->find(Event::$data['repack']['id']);

        $watcher_emails = array();
        $watchers = ORM::factory('profile')
            ->find_all_by_role(array('admin', 'editor'));
        foreach ($watchers as $p)
            $watcher_emails[] = $p->find_default_login_for_profile()->email;

        $recipients = array(
            'to'  => $repack->profile->find_default_login_for_profile()->email,
            'bcc' => $watcher_emails
        );

        Kohana::log('info', 
            'Sending notifications on ' . 
            $repack->profile->screen_name . '/' . $repack->short_name .
            ' state change of ' .  Event::$data['new_state'] .
            ' to ' . json_encode($recipients)
        );

        email::send_view(
            $recipients,
            'repacks/notifications/' . Event::$data['new_state'],
            array_merge(Event::$data, array('repack' => $repack))
        );

    }

}
Event::add('system.ready', array('Mozilla_BYOB_RepackNotifications', 'init'));