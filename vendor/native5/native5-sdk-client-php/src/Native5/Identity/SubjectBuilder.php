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
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Identity;

/**
 * SubjectBuilder 
 * 
 * @category  Identity
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class SubjectBuilder
{

    private $_context;

    private $_securityManager;


    /**
     * __construct 
     * 
     * @param mixed $securityManager The security manager
     *
     * @access public
     * @return void
     */
    public function __construct($securityManager=null)
    {
        $this->_context = new DefaultSubjectContext();
        if($securityManager === null)
            $this->_securityManager = SecurityUtils::getSecurityManager();

    }//end __construct()


    /**
     * session 
     * 
     * @param mixed $session The session object.
     *
     * @access public
     * @return SubjectBuilder
     */
    public function session($session)
    {
        $this->_context->setSession($session);
        return $this;

    }//end session()
    
    
    /**
     * principals 
     * 
     * @param mixed $principals The principals
     *
     * @access public
     * @return void
     */
    public function principals($principals)
    {
        $this->_context->setPrincipals($principals);
        return $this;

    }//end principals()


    /**
     * authenticated 
     * 
     * @param mixed $authStatus The authentication status.
     *
     * @access public
     * @return void
     */
    public function authenticated($authStatus)
    {
        $this->_context->setAuthenticated($authStatus);
        return $this;

    }//end authenticated()


    /**
     * authorization 
     * 
     * @param mixed $roles The roles using which to replicate the authorization state
     *
     * @access public
     * @return void
     */
    public function authorization($roles)
    {
        $this->_context->setRoles($roles);
        return $this;

    }//end authorization()


    /**
     * build 
     * 
     * @access public
     * @return void
     */
    public function build()
    {
        return $this->_securityManager->createSubject($this->_context);

    }//end build()


}//end class

?>
