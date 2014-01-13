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
 * DelegatingSubject 
 * 
 * @category  Identity 
 * @package   Native5\Identity
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 0.1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class DelegatingSubject extends Subject
{

    protected $principals;

    protected $host;

    protected $securityManager;


    /**
     * __construct 
     * 
     * @param mixed $principals      Principals 
     * @param mixed $authenticated   Authenticated
     * @param mixed $host            Host
     * @param mixed $session         Session
     * @param mixed $securityManager SecurityManager
     *
     * @access public
     * @return void
     */
    public function __construct(
        $principals,
        $authenticated,
        $host,
        $session,
        $roles,
        $securityManager
    ) {
        $this->principals      = $principals;
        $this->_authenticated  = $authenticated;
        $this->host            = $host;
        $this->_session        = $session;
        $this->_roles          = $roles; 
        $this->securityManager = $securityManager;

    }//end __construct()


    /**
     * getSecurityManager 
     * 
     * @access public
     * @return void
     */
    public function getSecurityManager()
    {
        return $this->securityManager;

    }//end getSecurityManager()


    /**
     * getHost 
     * 
     * @access public
     * @return void
     */
    public function getHost()
    {
        return $this->host;

    }//end getHost()


    /**
     * getPrincipal 
     * 
     * @access public
     * @return void
     */
    public function getPrincipal()
    {
        return $this->getPrimaryPrincipal($this->principals);

    }//end getPrincipal()


    /**
     * getPrincipals 
     * 
     * @access public
     * @return void
     */
    public function getPrincipals()
    {
        return $this->principals;

    }//end getPrincipals()


    /**
     * getRoles 
     * 
     * @access public
     * @return void
     */
    public function getRoles()
    {
        return $this->_roles;

    }//end getRoles()


    /**
     * getPrimaryPrincipal 
     * 
     * @access public
     * @return void
     */
    public function getPrimaryPrincipal()
    {
        return $this->principals[0];

    }//end getPrimaryPrincipal()


}//end class

?>
