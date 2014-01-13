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
 * @category  Password 
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Util\Password;

/**
 * %ClassName% 
 * 
 * @category  Password 
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class Password
{

    private $_password;
    private $_complexity;
    private $_lastReset;
    private $_last3Passwords;

    public function __construct($hash, $resetTime) {
        $this->_lastReset = time();
        $this->_last3Passwords=array();
        $this->_password = $hash;
        $this->_complexity = 4;
        if($resetTime != -1)
            $this->_lastReset = $resetTime;
    }

    public function getPasswordHash() {
        return $this->_password;
    }

    public function reset($newPassword=null) {
        $crypt = new \PasswordLib\PasswordLib;
        if ($newPassword == null) { // Auto Generate
            $newPassword = $crypt->getRandomToken(8);
            $this->_complexity = 4;
        }
        // TODO: Determine complexity of password sent by user
        $this->_password = $crypt->createPasswordHash($newPassword, '$2a$'); // Blowfish
        // Only Hashed passwords are returned
        $this->_lastReset = time();
        return $newPassword;
    }

    public function verify($password) {
        $crypt = new PasswordLib\PasswordLib;
        return $crypt->verifyPasswordHash($password, $this->_password); 
    }
    
    public function getResetTime() {
       return $this->_lastReset; 
    }

    public function getComplexity() {
        return $this->_complexity;
    }
}
?>
