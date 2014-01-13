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

use Native5\Services\Messaging\MessagingException;
use Native5\Services\Common\ApiClient;
use Native5\Services\Messaging\Notifier;
use Native5\Services\Messaging\Message;

/**
 * RemoteVoiceNotifier 
 * 
 * @category  Messaging 
 * @package   Native5\Services\Messaging
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class RemoteVoiceNotifier extends ApiClient implements Notifier
{


    /**
     * notify 
     * 
     * @param Message $message Message to send
     *
     * @access public
     * @return NotificationStatus
     * @throws MessagingException
     */
    public function notify(Message $message, $options=array())
    {
        $logger = $GLOBALS['logger'];
        $logger->debug(
            'Sending Voice Message ',
            array(
             $message->getFrom(),
             $message->getBody(),
            )
        );
        $path    = 'notifications/voice/send';
        $request = $this->_remoteServer->post($path);
        $request->setPostField('type', 'sms');
        $request->setPostField('from', $message->getFrom());
        $request->setPostField('to', implode(';', $message->getRecipients()));
        $request->setPostField('content', $message->getBody());

        try {
            $response = $request->send();
            if ($response->getStatusCode() !== 200) {
                throw new MessagingException();
            }

            $rawResponse = $response->getBody('true');

            return $rawResponse;
        } catch (\Exception $e) {
            throw new MessagingException();
        }

    }//end notify()


}//end class

?>
