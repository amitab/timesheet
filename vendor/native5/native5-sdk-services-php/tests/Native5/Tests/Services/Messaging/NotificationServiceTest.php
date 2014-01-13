<?php
/*
 *  Copyright 2012 Native5. All Rights Reserved 
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *		
 *	You may obtain a copy of the License at
 *	http://www.apache.org/licenses/LICENSE-2.0
 *  or in the "license" file accompanying this file.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *
 */

/**
 * 
 * @version 
 * @license See attached NOTICE.md for details
 * @copyright See attached LICENSE for details
 *
 * Created : 28-11-2012
 * Last Modified : Wed Nov 28 16:27:35 2012
 */
namespace Native5\Tests\Messaging;

use Native5\Services\Messaging\NotificationService;
use Native5\Services\Messaging\Notifier;
use Native5\Services\Messaging\MailMessage;
use Native5\Services\Messaging\SMSMessage;

class NotificationServiceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Native5\Services\Messaging\Messaging\NotificationService;
     */
    protected $object;

    /**
     * @var Native5\Core\Log\Logger
     */
    protected $_logger;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = NotificationService::instance();
        $this->_logger = $GLOBALS['logger'];
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }


    public function testEmail() {
        $channels = array();
        $channels[] = Notifier::TYPE_EMAIL;
        $email = new MailMessage;

        $email->setSubject('Test E-mail : Subject 001');
        $email->setBody('Testing E-mail Sending works.');
        $email->setRecipients(array('barry@native5.com'));

        $mailStatus = $this->object->sendNotification($channels, $email);
        $this->assertNotNull($mailStatus['mail']);
    }


    public function testSMS() {
        $channels = array();
        $channels[] = Notifier::TYPE_SMS;
        $sms = new SMSMessage;

        $sms->setBody('Testing SMS Sending works.');
        $sms->setRecipients(array('+917411755625'));

        $smsStatus = $this->object->sendNotification($channels, $sms);
        $this->assertNotNull($smsStatus['sms']);
    }
}
