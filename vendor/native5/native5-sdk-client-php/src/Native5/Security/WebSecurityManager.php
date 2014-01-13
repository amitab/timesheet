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
 * @category  Security 
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Security;

use Native5\Control\PreProcessor;
use Native5\Control\AuthenticationException;

/**
 * WebSecurityManager 
 * 
 * @category  Security 
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class WebSecurityManager implements PreProcessor
{


    /**
     * process Security Pre-Processor 
     * 
     * @param mixed $request The request to pre-process.
     *
     * @access public
     * @return void
     */
    public function process($request)
    {
        if (!($this->isAuthenticated($request) && $this->isAuthorized($request))) {
           throw new AuthenticationException();
        }

    }// end process()


    /**
     * isAuthenticated
     * 
     * @access public
     * @return void
     */
    protected function isAuthenticated($request)
    {
        global $logger;
        global $app;

        $session = $app->getSessionManager()->getActiveSession();
        $subject = $app->getSubject();
        return ($request->getParam('rand_token') == $session->getAttribute('nonce')) && $subject->isAuthenticated();

    }//end isAuthenticated()


    /**
     * isAuthorized 
     * 
     * @param mixed $request The request to authorize.
     *
     * @access protected
     * @return void
     */
    protected function isAuthorized($request)
    {
        global $app;
        $session = $app->getSubject();
        return true;
        //return $subject->isAuthorized();

    }//end isAuthorized()


}//end class

?>
