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
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Messaging;

/**
 * Message 
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
interface Message
{


    /**
     * getID 
     * 
     * @access public
     * @return void
     */
    public function getID();


    /**
     * setSubject 
     * 
     * @param mixed $subj Subject.
     *
     * @access public
     * @return void
     */
    public function setSubject($subj);


    /**
     * getSubject 
     * 
     * @access public
     * @return void
     */
    public function getSubject();


    /**
     * setBody 
     * 
     * @param mixed $body Body of the message.
     *
     * @access public
     * @return void
     */
    public function setBody($body);


    /**
     * getBody 
     * 
     * @access public
     * @return void
     */
    public function getBody();


    /**
     * setRecipients 
     * 
     * @param mixed $recipients Message receipients
     *
     * @access public
     * @return void
     */
    public function setRecipients($recipients);


    /**
     * getRecipients 
     * 
     * @access public
     * @return void
     */
    public function getRecipients();


}//end interface

?>
