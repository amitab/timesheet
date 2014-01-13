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

use Native5\Sessions\SessionManager;
use Native5\Sessions\WebSessionManager;
use Native5\Services\Identity\RemoteAuthenticationService;

/**
 * DefaultSecurityManager
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
class DefaultSecurityManager implements Authenticator, SessionManager
{

    private $_authenticator;

    private $_subjectDAO;

    private $_sessionManager;


    /**
     * __construct Default Constructor 
     * 
     * @param mixed $authenticator Authenticator to use. 
     *
     * @access public
     * @return void
     */
    public function __construct($authenticator=null)
    {
        if (!empty($authenticator)) {
            $this->_authenticator = $authenticator;
        } else {
            $this->_authenticator = new RemoteAuthenticationService();
        }

        $this->_subjectDAO     = new DefaultSubjectDAO();
        $this->_sessionManager = new WebSessionManager();

    }//end __construct()


    /**
     * login Logs in the subject. 
     * 
     * @param mixed $subject Subject to authenticate 
     * @param mixed $token   Token to be used for authentication.
     *
     * @access public
     * @return void
     * @throws AuthenticationException
     */
    public function login(&$subject, $token)
    {
        global $logger;
        global $app;
        try {
            list($authInfo, $roles, $tokens) = $this->authenticate($token);
        } catch (AuthenticationException $aex) {
            $logger->error($aex->getMessage(), array($aex->getMessage()));
            throw $aex;
        }
        $loggedInSubj = $this->_createSubject($token, $authInfo, $subject, $roles);

        $logger->debug('User Logged in as : '.print_r($subject,1));
        // Generate unique token to prevent XSRF.
        $app->getSessionManager()->getActiveSession()->setAttribute('nonce', sha1(uniqid(mt_rand(), true))); 
        $app->getSessionManager()->getActiveSession()->setAttribute(DefaultSubjectContext::AUTHENTICATED_SESSION_KEY, true);
        if(!empty($tokens)) {
            $app->getSessionManager()->getActiveSession()->setAttribute('sharedKey', $tokens['token']); 
            $app->getSessionManager()->getActiveSession()->setAttribute('secretKey', $tokens['secret']); 
        }
        return $loggedInSubj;

    }//end login()


    /**
     * logout 
     * 
     * @param mixed $subject Subject to logout 
     *
     * @access public
     * @return void
     */
    public function logout(&$subject)
    {
        $this->_delete($subject);

    }//end logout()


    /**
     * createSubject Creating the subject using the given context. 
     * 
     * @param mixed $context The context used to create the subject. 
     *
     * @access public
     * @return void
     */
    public function createSubject($context)
    {
        global $logger;
        //$copyContext = $this->copy($context);
        //$copyContext = $this->_ensureSecurityMgr($copyContext);
        //$copyContext = $this->_resolveSession($copyContext);
        //$copyContext = $this->_resolvePrincipals($copyContext);
        $subject     = $this->doCreateSubject($context);
        $this->_save($subject);

        return $subject;

    }//end createSubject()


    /**
     * copy 
     * 
     * @param mixed $context The context object to copy.
     *
     * @access public
     * @return void
     */
    public function copy($context)
    {
        return new DefaultSubjectContext($context);

    }//end copy()


    /**
     * _ensureSecurityMgr 
     * 
     * @param mixed $context The context to use for the security manager.
     *
     * @access private
     * @return void
     */
    private function _ensureSecurityMgr($context)
    {
        return $context;

    }//end _ensureSecurityMgr()


    /**
     * _resolveSession 
     * 
     * @param mixed $context Resolving the session.
     *
     * @access private
     * @return void
     */
    private function _resolveSession($context)
    {
        return $context;

    }//end _resolveSession()


    /**
     * _resolvePrincipals 
     * 
     * @param mixed $context The context
     *
     * @access private
     * @return void
     */
    private function _resolvePrincipals($context)
    {
        return $context;

    }//end _resolvePrincipals()


    /**
     * authenticate 
     * 
     * @param mixed $token The token.
     *
     * @access public
     * @return void
     */
    public function authenticate($token)
    {
        return $this->_authenticator->authenticate($token);

    }//end authenticate()


    /**
     * startSession 
     * 
     * @param mixed $context The context.
     *
     * @access public
     * @return void
     */
    public function startSession($context=null, $useExisting=false)
    {
        return $this->_sessionManager->startSession();

    }//end startSession()


    /**
     * getSession 
     * 
     * @param mixed $sessKey Session Key.
     *
     * @access public
     * @return void
     */
    public function getSession($sessKey)
    {
        return $this->_sessionManager->getSession($sessKey);

    }//end getSession()


    /**
     * endSession 
     * 
     * @param mixed $sessKey Session Key
     *
     * @access public
     * @return void
     */
    public function endSession($sessKey)
    {
        $this->_sessionManager->endSession($sessKey);

    }//end endSession()


    /**
     * destroy 
     * 
     * @access public
     * @return void
     */
    public function destroy()
    {
        $this->_sessionManager->endSession();

    }//end destroy()


    /**
     * _createSubject 
     * 
     * @param mixed $token    Token
     * @param mixed $info     Authentication Info
     * @param mixed $existing Existing token
     * @param array $roles    The roles to use. 
     *
     * @access protected
     * @return void
     */
    protected function _createSubject($token, $info, $existing, $roles=array())
    {
        global $logger;
        $context = $this->createSubjectContext();
        $context->setAuthenticated(true);
        $context->setAuthenticationToken($token);
        $context->setAuthenticationInfo($info);
        $context->setRoles($roles);
        if ($existing !== null)
            $context->setSubject($existing);
        return $this->createSubject($context);

    }//end _createSubject()


    /**
     * createSubjectContext 
     * 
     * @access protected
     * @return void
     */
    protected function createSubjectContext()
    {
        return new DefaultSubjectContext();

    }//end createSubjectContext()


    /**
     * doCreateSubject 
     * 
     * @param mixed $context SubjectContext
     *
     * @access protected
     * @return void
     */
    protected function doCreateSubject($context)
    {
        global $logger;
        $securityManager = $context->resolveSecurityManager();
        $session         = $context->resolveSession();
        $principals      = $context->resolvePrincipals();
        $authenticated   = $context->resolveAuthenticated();
        $roles           = $context->resolveRoles();
        $host            = $context->resolveHost();

        return new DelegatingSubject(
            $principals,
            $authenticated,
            $host,
            $session,
            $roles,
            $securityManager
        );

    }//end doCreateSubject()


    /**
     * _save 
     * 
     * @param Subject $subject The subject to save.
     *
     * @access protected
     * @return void
     */
    protected function _save(Subject $subject)
    {
        $this->_subjectDAO->save($subject);

    }//end _save()


    /**
     * _delete 
     * 
     * @param Subject $subject The subject to delete. 
     *
     * @access protected
     * @return void
     */
    protected function _delete(Subject $subject)
    {
        $this->_subjectDAO->delete($subject);

    }//end _delete()


}//end class

?>
