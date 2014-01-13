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
 * DefaultSubjectDAO
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
class DefaultSubjectDAO implements SubjectDAO
{


    /**
     * save 
     * 
     * @param Subject $subject The subject to save.
     *
     * @access public
     * @return void
     */
    public function save(Subject $subject)
    {
        $this->_saveToSession($subject);

        return $subject;

    }//end save()


    /**
     * destroy 
     * 
     * @param Subject $subject The subject to destroy.
     *
     * @access public
     * @return void
     */
    public function destroy(Subject $subject)
    {
        $this->_removeFromSession($subject);

    }//end destroy()


    /**
     * _saveToSession 
     * 
     * @param mixed $subject The session to save.
     *
     * @access protected
     * @return void
     */
    protected function _saveToSession($subject)
    {
        $this->mergePrincipals($subject);
        $this->mergeAuthenticationState($subject);
        $this->mergeAuthorizationState($subject);

    }//end _saveToSession()


    /**
     * mergeAuthorizationState 
     * 
     * @param mixed $subject The subject from which to save the Authorization State.
     *
     * @access protected
     * @return void
     */
    protected function mergeAuthorizationState($subject)
    {
        $currentRoles = $subject->getRoles();
        $session      = $subject->getSession(false);

        if ($session === null) {
            if (!empty($currentRoles)) {
                $session = $subject->getSession();
                $session->setAttribute(DefaultSubjectContext::AUTHORIZATION_SESSION_KEY, $currentRoles);
            }
        } else {    //otherwise no session and no roles - nothing to save
            $existingRoles =
                    $session->getAttribute(DefaultSubjectContext::AUTHORIZATION_SESSION_KEY);

            if (empty($currentRoles)) {
                if (!empty($existingRoles)) {
                    $session->removeAttribute(DefaultSubjectContext::AUTHORIZATION_SESSION_KEY);
                }
            } else {    //otherwise both are null or empty - no need to update the session
                if ($currentRoles !== $existingRoles) {
                    $session->setAttribute(DefaultSubjectContext::AUTHORIZATION_SESSION_KEY, $currentRoles);
                }
            }
        }

    }//end mergeAuthorizationState()


    /**
     * mergePrincipals 
     * 
     * @param mixed $subject subject whose principals need to be merged.
     *
     * @access protected
     * @return void
     */
    protected function mergePrincipals($subject)
    {
        $currentPrincipals = $subject->getPrincipals();
        $session = $subject->getSession(false);

        if ($session === null) {
            if (!empty($currentPrincipals)) {
                $session = $subject->getSession();
                $session->setAttribute(DefaultSubjectContext::PRINCIPALS_SESSION_KEY, $currentPrincipals);
            }
        } else {    //otherwise no session and no principals - nothing to save
            $existingPrincipals =
                    $session->getAttribute(DefaultSubjectContext::PRINCIPALS_SESSION_KEY);

            if (empty($currentPrincipals)) {
                if (!empty($existingPrincipals)) {
                    $session->removeAttribute(DefaultSubjectContext::PRINCIPALS_SESSION_KEY);
                }
            } else {    //otherwise both are null or empty - no need to update the session
                if ($currentPrincipals !== $existingPrincipals) {
                    $session->setAttribute(DefaultSubjectContext::PRINCIPALS_SESSION_KEY, $currentPrincipals);
                }
            }
        }
    
    }//end mergePrincipals()


    /**
     * mergeAuthenticationState
     *
     * @param mixed $subject Subject whose authentication state needs to be merged
     *
     * @access protected
     * @return void
     */
    protected function mergeAuthenticationState($subject)
    {
        global $logger;
        $session = $subject->getSession(false);
        //$logger->debug('Sesssion Object ='.print_r($session,1)); 
        //$logger->debug('Subject Auth ='.$subject->isAuthenticated()); 
        if ($session == null) {
            if ($subject->isAuthenticated()) {
                $session = $subject->getSession(true);
                $session->setAttribute(DefaultSubjectContext::AUTHENTICATED_SESSION_KEY, true);
            }
            //otherwise no session and not authenticated - nothing to save
        } else {
            $existingAuthc = $session->getAttribute(DefaultSubjectContext::AUTHENTICATED_SESSION_KEY);
            if ($subject->isAuthenticated()) {
                if ($existingAuthc == null || !$existingAuthc) {
                    $session->setAttribute(DefaultSubjectContext::AUTHENTICATED_SESSION_KEY, true);
                }
                //otherwise authc state matches - no need to update the session
            } else {
                if ($existingAuthc != null) {
                    //existing doesn't match the current state - remove it:
                    $session->removeAttribute(DefaultSubjectContext::AUTHENTICATED_SESSION_KEY);
                }
                //otherwise not in the session and not authenticated - no need to update the session.
            }
        }

    }//end mergeAuthenticationState()


    /**
     * removeFromSession 
     * 
     * @param mixed $subject The subject to remove from the session.
     *
     * @access protected
     * @return void
     */
    protected function removeFromSession($subject)
    {
        $session = $subject->getSession(false);
        if ($session !== null) {
            $session->removeAttribute(SessionSubjectContext::AUTHENTICATED_SESSION_KEY);
            $session->removeAttribute(SessionSubjectContext::PRINCIPALS_SESSION_KEY);
        }

    }//end removeFromSession()


}//end class

?>
