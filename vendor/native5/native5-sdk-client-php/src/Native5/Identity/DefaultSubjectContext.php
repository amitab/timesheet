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
 * Identity
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
class DefaultSubjectContext
{

    const SECURITY_MANAGER          = 'DefaultSubjectContext.SECURITY_MANAGER';
    const SESSION_ID                = 'DefaultSubjectContext.SESSION_ID';
    const AUTHENTICATION_TOKEN      = 'DefaultSubjectContext.AUTHENTICATION_TOKEN';
    const AUTHENTICATION_INFO       = 'DefaultSubjectContext.AUTHENTICATION_INFO';
    const AUTHORIZATION_INFO        = 'DefaultSubjectContext.AUTHORIZATION_INFO';
    const SUBJECT                   = 'DefaultSubjectContext.SUBJECT';
    const PRINCIPALS                = 'DefaultSubjectContext.PRINCIPALS';
    const ROLES                     = 'DefaultSubjectContext.ROLES';
    const SESSION                   = 'DefaultSubjectContext.SESSION';
    const AUTHENTICATED             = 'DefaultSubjectContext.AUTHENTICATED';
    const HOST                      = 'DefaultSubjectContext.HOST';
    const PRINCIPALS_SESSION_KEY    = 'DefaultSubjectContext._PRINCIPALS_SESSION_KEY';
    const AUTHENTICATED_SESSION_KEY = 'DefaultSubjectContext._AUTHENTICATED_SESSION_KEY';
    const AUTHORIZATION_SESSION_KEY = 'DefaultSubjectContext._AUTHORIZATION_SESSION_KEY';

    private $_map;

    /**
     * __construct 
     * 
     * @access public
     * @return void
     */
    public function __construct($context=null)
    {
        $this->_map = array();
        if($context != null)
        {
           //$this->_map = $context->clone(); 
        }

    }//end __construct()


    /**
     * getSecurityManager 
     * 
     * @access public
     * @return void
     */
    public function getSecurityManager()
    {
        if(array_key_exists(self::SECURITY_MANAGER, $this->_map))
            return $this->_map[self::SECURITY_MANAGER];
        return null;

    }//end getSecurityManager()


    /**
     * setSecurityManager 
     * 
     * @param mixed $securityManager The security manager to use.
     *
     * @access public
     * @return void
     */
    public function setSecurityManager($securityManager)
    {
        $this->nullSafePut(self::SECURITY_MANAGER, $securityManager);
    }

    public function resolveSecurityManager()
    {
        global $logger;
        $securityManager = $this->getSecurityManager();
        if ($securityManager == null) {
            $logger->debug("No SecurityManager available in subject context map.  " +
                        "Falling back to SecurityUtils.getSecurityManager() lookup.");
            try {
                $securityManager = SecurityUtils::getSecurityManager();
            } catch (\Exception $e) {
                $logger->debug("No SecurityManager available via SecurityUtils.  Heuristics exhausted.");
            }
        }

        return $securityManager;
    }

    public function getSessionId()
    {
        return $this->_map[self::SESSION_ID];
    }

    public function setSessionId($sessionId)
    {
        $this->nullSafePut(self::SESSION_ID, $sessionId);
    }

    public function getSubject()
    {
        if(array_key_exists(self::SUBJECT, $this->_map))
            return $this->_map[self::SUBJECT];
        return null;
    }

    public function setSubject($subject)
    {
        $this->nullSafePut(self::SUBJECT, $subject);
    }

    public function getPrincipals()
    {
        if(array_key_exists(self::PRINCIPALS, $this->_map))
            return $this->_map[self::PRINCIPALS];
        return null;
    }

    public function setPrincipals($principals)
    {
        if (!empty($principals)) {
            $this->_map[self::PRINCIPALS]= $principals;
        }
    }

    public function resolvePrincipals()
    {
        $principals = $this->getPrincipals();

        if (empty($principals)) {
            //check to see if they were just authenticated:
            $info = $this->getAuthenticationInfo();
            if ($info != null) {
                $principals = $info->getPrincipals();
            }
        }

        if (empty($principals)) {
            $subject = $this->getSubject();
            if ($subject != null) {
                $principals = $subject->getPrincipals();
            }
        }

        if (empty($principals)) {
            //try the session:
            $session = $this->resolveSession();
            if ($session != null) {
                $principals = $session->getAttribute(self::PRINCIPALS_SESSION_KEY);
            }
        }

        return $principals;
    }


    public function resolveRoles()
    {
        $roles = $this->getRoles();

        if (empty($roles)) {
            $info = $this->getAuthorizationInfo();
            if ($info != null) {
                $roles= $info->getRoles();
            }
        }
        return $roles;
    }
    
    public function getRoles() {
        if(array_key_exists(self::ROLES, $this->_map))
            return $this->_map[self::ROLES];
        return array();
    }


    public function setRoles($roles)
    {
        $this->_map[self::ROLES] = $roles;
    }

    public function getSession()
    {
        if(array_key_exists(self::SESSION, $this->_map))
            return $this->_map[self::SESSION];
        return null;
    }

    public function setSession($session)
    {
        $this->nullSafePut(self::SESSION, $session);
    }

    public function resolveSession()
    {
        global $logger;
        $session = $this->getSession();
        if ($session == null) {
            //try the Subject if it exists:
            $existingSubject = $this->getSubject();
            if ($existingSubject != null) {
                $session = $existingSubject->getSession(false);
            }
        }
        return $session;
    }


    /**
     * isAuthenticated 
     * 
     * @access public
     * @return void
     */
    public function isAuthenticated()
    {
        if(!array_key_exists(self::AUTHENTICATED, $this->_map))
            return false;

        $authc      = $this->_map[self::AUTHENTICATED];
        $authStatus = ($authc != null && $authc);
        return $authStatus;
    }

    public function setAuthenticated($authc)
    {
        $this->_map[self::AUTHENTICATED] = $authc;
    }

    public function resolveAuthenticated()
    {
        $authc= null;
        if(array_key_exists(self::AUTHENTICATED, $this->_map))
            $authc = $this->_map[self::AUTHENTICATED];
        if ($authc == null) {
            //see if there is an AuthenticationInfo object.  If so, the very presence of one indicates a successful
            //authentication attempt:
            $info = $this->getAuthenticationInfo();
            $authc = $info != null;
        }
        if (!$authc) {
            //fall back to a session check:
            $session = $this->resolveSession();
            if ($session != null) {
                $sessionAuthc = $session->getAttribute(self::AUTHENTICATED_SESSION_KEY);
                $authc = $sessionAuthc != null && $sessionAuthc;
            }
        }
        return $authc;
    }

    public function getAuthenticationInfo()
    {
        if(array_key_exists(self::AUTHENTICATION_INFO, $this->_map))
            return $this->_map[self::AUTHENTICATION_INFO];
        return null;
    }

    public function setAuthenticationInfo($info)
    {
        $this->nullSafePut(self::AUTHENTICATION_INFO, $info);
    }

    public function getAuthenticationToken()
    {
        if(array_key_exists(self::AUTHENTICATION_TOKEN, $this->_map))
            return $this->_map[self::AUTHENTICATION_TOKEN];
        return null;
    }

    public function setAuthenticationToken($token)
    {
        $this->nullSafePut(self::AUTHENTICATION_TOKEN, $token);
    }

    public function getAuthorizationInfo()
    {
        if(array_key_exists(self::AUTHORIZATION_INFO, $this->_map))
            return $this->_map[self::AUTHORIZATION_INFO];
        return null;
    }

    public function setAuthorizationInfo($token)
    {
        $this->nullSafePut(self::AUTHORIZATION_INFO, $token);
    }
    
    public function getHost()
    {
        if(array_key_exists(self::HOST, $this->_map))
            return $this->_map[self::HOST];
        return null;
    }

    public function setHost($host)
    {
        $this->_map[self::HOST] = $host;
    }


    /**
     * resolveHost 
     * 
     * @access public
     * @return void
     */
    public function resolveHost()
    {
        $host = $this->getHost();

        if ($host == null) {
            //check to see if there is an AuthenticationToken from which to retrieve it:
            $token = $this->getAuthenticationToken();
            //if ($token instanceof $HostAuthenticationToken) {
            if($token)
                $host = 'API Services';
            //}
        }

        if ($host == null) {
            $session = $this->resolveSession();
            if ($session != null) {
                $host = $session->getHost();
            }
        }

        return $host;

    }//end resolveHost()


    /**
     * nullSafePut 
     * 
     * @param mixed $key  Key for element.
     * @param mixed $elem Element to put.
     *
     * @access public
     * @return void
     */
    public function nullSafePut($key, $elem)
    {
        if($elem !== null && !empty($elem)) {
            $this->_map[$key] = $elem;
        }

    }//end nullSafePut()


}//end class

?>
