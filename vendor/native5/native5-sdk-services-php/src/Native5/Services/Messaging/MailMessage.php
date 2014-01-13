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
 * @category  Notifications 
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Messaging;

use Native5\Services\Messaging\Message;

/**
 * MailMessage 
 * 
 * @category  Notifications 
 * @package   Native5\Services\Messaging
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class MailMessage implements Message
{

    private $_subject;

    private $_body;

    private $_attachments;

    private $_to;

    private $_id;


    /**
     * __construct 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_id = uniqid('mm'); 

    }//end __construct()

    public function getID() {
        return $this->_id;
    }

    public function setSubject($subj) {
        $this->_subject = $subj;	
    }

    public function getSubject() {
        return $this->_subject;
    }

    public function setBody($body) {
        $this->_body = $body;
    }

    public function getBody() {
        return $this->_body;
    }

    public function setRecipients ($to) {
        $this->_to = $to;
    }

    public function getRecipients () {
        return $this->_to;
    }

    public function setAttachments($attachments) {
        $this->_attachments = $attachments;
    }

    public function getAttachments() {
        return $this->_attachments;
    }
}

