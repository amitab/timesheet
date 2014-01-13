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
 * Subject 
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
class Subject {

    private $_principal;
    private $_principals;
    protected $_roles;
    private $_permissions;
    protected $_authenticated;
    protected $_session;

    /**
     * createBuilder 
     * 
     * @param mixed $securityManager The security manager for the builder.
     *
     * @static
     * @access public
     * @return void
     */
    public static function createBuilder($securityManager=null) {
        return new SubjectBuilder($securityManager);
    }


    /**
     * __construct 
     * 
     * @param mixed $context SubjectContext to use to build the session.
     *
     * @access public
     * @return void
     */
    public function __construct($context=null) {
        $this->_setPrincipal('Guest');
        $this->_principals = array();
        $this->_principals[] = $this->_principal;
        $this->_roles = array();
        $this->_permissions = array();
        $this->_session = SecurityUtils::getSecurityManager()->startSession();
        $this->_authenticated = false;	
    }


    public function getPrincipals() {
        return $this->_principals;
    }

    public function addPrincipal($principal) {
        $this->_principals[] = $principal;
    }

    private function _setPrincipal($username) {
        $this->_principal = $username;
    }


    public function getPrincipal() {
        return $this->_principal;
    }


    public function isAuthenticated()
    {
        return $this->_authenticated;
    }


    public function isAuthorized($resource) {
        throw new Exception('Operation not supported');
    }


    public function isPermitted($permission) {
        throw new Exception('Operation not supported');
    }


    public function hasRole($roleName) {

        return !empty($this->_roles) && (in_array($roleName, $this->_roles));

    }//end hasRole()


    /**
     * login 
     * 
     * @param mixed $token The token to use to login the subject
     *
     * @access public
     * @return void
     */
    public function login($token)
    {
        $subject           = SecurityUtils::getSecurityManager()->login($this, $token);
        $this->_principal  = $subject->getPrincipal();
        $this->_principals = $subject->getPrincipals();

        if ($this->_principals === null || empty($this->_principals)) {
            $msg = "Principals returned from SecurityManager->login( token ) returned an empty set.".
                    "This must be populated with one or more elements.";
            throw new \Exception(msg);
        }
        $this->_authenticated = true;

    }//end login()


    /**
     * logout 
     * 
     * @access public
     * @return void
     */
    public function logout()
    {
        try {
            SecurityUtils::getSecurityManager()->logout($this);
        } catch (\Exception $ex) {
            $this->_principals    = null;
            $this->_authenticated = false;
            $this->_session       = null;
        }

    }//end logout()


    /**
     * getSession 
     * 
     * @param mixed $create The params to create.
     *
     * @access public
     * @return void
     */
    public function getSession($create=true)
    {
        global $logger;
        if ($this->_session == null && $create==true) {
            $this->_session = SecurityUtils::getSecurityManager()->startSession();
        }
        return $this->_session;

    }//end getSession()


}//end class

?>
