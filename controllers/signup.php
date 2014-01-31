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

use Timesheet\User\DAOImpl as UserDAOImpl;
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
class SignupController extends DefaultController
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
        $skeleton =  new TwigRenderer('signup.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $this->_response->setBody(array(
            'title' => 'Sign Up',
            'login' => true,
        ));

    }
    
    private function _create_user($user, $password, $roles) {
        global $logger;
        
        try {
            $user =
                \Native5\Services\Users\User::createBuilder($user->getUserMail())
                    ->setPassword($password)
                    ->setName($user->getUserFirstName() . ' ' . $getUserLastName())
                    ->setRoles(
                       $roles
                    )
                    ->setAliases(
                        array(
                            'email' => $user->getUserMail(),
                            'userId' => $user->getUserId(),
                            'mobile' => $user->getUserPhoneNumber()
                        )
                    )
                    ->build();
            $userManager = new Native5\Services\Users\DefaultUserManager();
            if($userManager->createUser($user)) {
                $message = 'Successfuly created user.';
            } else {
                $message = 'Failed to create user.';
            }
            
        } catch (\Exception $e) {
            $message = 'Failed to create user.';
            $logger->info($e->getMessage());
        }
    }
    
    public function _tester($request) {
        global $logger;
        $userService = \Timesheet\User\Service::getInstance();
        $users = $userService->getAllUsers();
        
        foreach($users as $user) {
            $this->_create_user($user, $password, $roles);
        }
    }

}//end class

?>
