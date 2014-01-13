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
 * @category  Identity 
 * @package   Native5\Identity
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Identity;

/**
 * DefaultAccount 
 * 
 * @category  Identity 
 * @package   Native5\Identity
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class DefaultAccount implements Account
{
    private $_principals;
    private $_credentials;
    private $_permissions;
    private $_roles;

    public function __construct() {
        $this->_roles = array();
        $this->_permissions = array();
    }

    public function setPrincipals($principals) {
        $this->_principals = $principals;
    }

    public function setCredentials($creds) {
        $this->_credentials = $creds;
    }

    public function getPrincipals() {
        return $this->_principals;	
    }

    public function getCredentials() {
        return $this->_credentials;
    }

    public function getPermissions() {
        throw new Exception('Operation not supported');
    }

    public function getRoles() {
        throw new Exception('Operation not supported');
    }

    public function equals($other) {
        return $this->getPrincipals() == $other->getPrincipals(); 
    }


}//end class

?>
