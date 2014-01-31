<?php
/**
 * Copyright © 2013 Native5
 * 
 * All Rights Reserved.  
 * Licensed under the Native5 License, Version 1.0 (the "License"); 
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at
 *  
 *      http://www.native5.com/legal/npl-v1.html
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
 * Home Controller
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
class HomeController extends DefaultController
{


    /**
     * _default 
     * 
     * @param mixed $request Request to use
     *
     * @access public
     * @return void
     */
    public function _default($request)
    {
        global $logger;
        $skeleton =  new TwigRenderer('auth.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $this->_response->setBody(array(
            'title' => 'Login',
            'login' => true,
        ));

    }//end _default()
	
	private function _validate($request) {
	    $firstName = trim($request->getParam('first_name'));
	    $lastName = trim($request->getParam('last_name'));
	    $email = trim($request->getParam('email'));
	    $phoneNumber = trim($request->getParam('phone_number'));
	    $location = trim($request->getParam('location'));
	    
	    if(!preg_match("/^[A-Z][a-zA-Z -]+$/", $firstName)) {
	        $message['fail'][] = 'First Name must be from letters, dashes, spaces and must not start with dash.';
	    }
	    
	    if(!preg_match("/^[A-Z][a-zA-Z -]+$/", $lastName)) {
	        $message['fail'][] = 'Last Name must be from letters, dashes, spaces and must not start with dash.';
	    }
	    
	    if(!preg_match("/\+\d{12}/", $phoneNumber) ) {
	        $message['fail'][] = 'Phone number is invalid.';
	    }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message['fail'][] = 'Email is invalid.';
        }
        
	    if(!$firstName) {
	        $message['fail'][] = 'First Name is empty.';
	    }
	    if(!$lastName) {
	        $message['fail'][] = 'Last Name is empty.';
	    }
	    if(!$email) {
	        $message['fail'][] = 'Email is empty.';
	    }
	    if(!$phoneNumber) {
	        $message['fail'][] = 'Phone Number is empty.';
	    }
	    if(!$location) {
	        $message['fail'][] = 'Location is empty.';
	    }
	    
	    if(!empty($message)) {
	        return $message;
	    }
	    else {
	        return true;
	    }
	    
	}
	
	private function _create_user($newUser, $password) {
        global $logger;
        
        try {
            $user = \Native5\Services\Users\User::createBuilder($newUser->getUserMail())
                    ->setPassword($password)
                    ->setName($newUser->getUserFirstName() . ' ' . $newUser->getUserLastName())
                    ->setAliases(
                        array(
                            'email' => $newUser->getUserMail(),
                            'userId' => $newUser->getUserId(),
                            'mobile' => $newUser->getUserPhoneNumber()
                        )
                    )
                    ->build();
            $userManager = new Native5\Services\Users\DefaultUserManager();
            $retVal = $userManager->createUser($user);
            
            if($retVal) {
                $userService = \Timesheet\User\Service::getInstance();
                if(!$userService->createUser($newUser)) {
                    throw new \Exception();
                } else {
                    return true;
                }
                
            } else {
                return false;
            }
            
        } catch (\Exception $e) {
            $logger->info($e->getMessage());
            return false;
        }
    }
	
	public function _signup($request)
    {        
        global $logger;
        $skeleton =  new TwigRenderer('signup.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        if($request->getParam('new_user') != null) {
            $message = $this->_validate($request);
            if(!isset($message['fail'])) {
                $user = new \Timesheet\User\User();
                $user->setUserLocation(trim($request->getParam('location')));
                $user->setUserMail(trim($request->getParam('email')));
                $user->setUserPhoneNumber(trim($request->getParam('phone_number')));
                $user->setUserImageUrl('default.jpg');
                $user->setUserFirstName(trim($request->getParam('first_name')));
                $user->setUserLastName(trim($request->getParam('last_name')));
                $user->setUserSex(trim($request->getParam('sex')));
                
                $password = trim($request->getParam('password'));
                
                if($this->_create_user($user, $password)) {
                    $this->_response->redirectTo('home');
                } else {
                    $info['fail'] = 'You shall not pass!!';
                }
            } else {
                $info['fail'] = 'You shall not pass!! Unless You correct your mistakes that is.';
            }
        }
        
        $this->_response->setBody(array(
            'title' => 'Sign Up',
            'login' => true,
            
            'info' => $info,
            'message' => $message
        ));

    }

}//end class

?>
