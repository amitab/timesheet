<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Messaging 
 * @package   Native5\Services\Messaging
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Messaging;

/**
 * NotificationService
 * 
 * @category  NotificationService 
 * @package   Native5\Services\Messaging
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class NotificationService
{

    private static $_instance;

    private $_registry;


    /**
     * Create an instance of Notification Service. 
     * 
     * @static
     * @access public
     * @return void
     */
    public static function instance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;

    }//end instance()


    /**
     * __construct 
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
        $this->_registry = array();
        $this->_registry[Notifier::TYPE_EMAIL] = new RemoteMailNotifier();
        $this->_registry[Notifier::TYPE_VOICE] = new RemoteVoiceNotifier();
        $this->_registry[Notifier::TYPE_SMS]   = new RemoteSMSNotifier();

    }//end __construct()


    /**
     * sendNotification 
     * 
     * @param mixed   $channels Channels on which to send message 
     * @param Message $message  Message to send
     *
     * @access public
     * @return void
     */
    public function sendNotification($channels, Message $message, $options=array())
    {
        $status = array();
        foreach ($channels as $channel) {
            $notifier = $this->_getNotifier($channel);
            if (empty($notifier) === false) {
                $status[$channel] = $notifier->notify($message, $options);
            }

            return $status;
        }

    }//end sendNotification()


    /**
     * sendAdminNotification 
     * 
     * @param mixed $msgText Text message to send.
     *
     * @access public
     * @return void
     */
    public function sendAdminNotification($msgText)
    {
        $message = new MailMessage();
        $message->setSubject('Native5 Server : P1 Issue');
        $message->setBody($msgText);
        $mReceipents   = array();
        $mReceipents[] = 'barry@native5.com';
        $message->setRecipients($mReceipents);
        $this->sendNotification(array(Notifier::TYPE_EMAIL), $message);

    }//end sendAdminNotification()


    /**
     * getNotifier 
     * 
     * @param mixed $channel Channel for which to get notifier for.
     *
     * @access private
     * @return void
     */
    private function _getNotifier($channel)
    {
        return $this->_registry[$channel];

    }//end _getNotifier()


}//end class

?>
