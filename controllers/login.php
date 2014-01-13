<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Controllers
 * @package   App/Controllers
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

use Native5\Control\DefaultController;
use Native5\Route\HttpResponse;
use Native5\UI\TwigRenderer;
use Native5\Identity\UsernamePasswordToken;
use Native5\Identity\AuthenticationException;
use Native5\Identity\SecurityUtils;

/**
 * LoginController
 *
 * @category  Controllers 
 * @package   App/Controllers 
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class LoginController extends DefaultController
{


    /**
     * _default 
     * 
     * @param mixed $request The incoming request 
     *
     * @access public
     * @return void
     */
    public function _default($request)
    {
        global $logger;
        global $app;

        $subject = SecurityUtils::getSubject();
        $logger->debug('Authentication Status '.$subject->isAuthenticated());

        if ($subject->isAuthenticated() === true) {
            $this->_response->redirectTo('dashboard');
        } else {
            $token = new UsernamePasswordToken(
                $request->getParam('uname'),
                $request->getParam('upass')
            );

            try {
                $subject->login($token);
                $this->_response->redirectTo('dashboard');
            } catch (AuthenticationException $aex) {
                $this->_handleFailedAuthentication($subject, $token, $aex);
            }
        }

    }//end _default()


    /**
     * _handleFailedAuthentication 
     * 
     * @param mixed $subject The subject
     * @param mixed $token   The tokens used to authenticate
     * @param mixed $aex     The exception
     *
     * @access private
     * @return void
     */
    private function _handleFailedAuthentication($subject, $token, $aex)
    {
        $this->_response->redirectTo('home');
        $this->_response->setBody(
            array('message' => 'Either username or password is incorrect.')
        );

    }//end _handleFailedAuthentication()

}//end class

?>
