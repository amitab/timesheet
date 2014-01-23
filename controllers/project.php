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
class ProjectController extends DefaultController
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
        $skeleton =  new TwigRenderer('projects-test.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $auth = true;
        
        /*$subject = SecurityUtils::getSubject();
        if ($subject->isAuthenticated() === true) {
            $this->_response->redirectTo('dashboard');
        }*/
        
        $this->_response->setBody(array(
            'title' => 'Projects',
            'auth' => $auth,
        ));      

    }//end _default()
    
    public function _details($request) {
        
        global $logger;
        $skeleton =  new TwigRenderer('projectdetails.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $auth = true;
        
        /*$subject = SecurityUtils::getSubject();
        if ($subject->isAuthenticated() === true) {
            $this->_response->redirectTo('dashboard');
        }*/
        
        $this->_response->setBody(array(
            'title' => 'Project Details',
            'auth' => $auth,
            'is_admin' => true,
            'is_employee' => false
        ));  
    }
    
    public function _create_new($request) {
        
        global $logger;
        $skeleton =  new TwigRenderer('createproject.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $auth = true;
        
        $this->_response->setBody(array(
            'title' => 'New Project',
            'auth' => $auth,
        ));  
    }
    
    public function _add_users($request) {
        
        global $logger;
        $skeleton =  new TwigRenderer('adduserstoproject.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $auth = true;
        
        $this->_response->setBody(array(
            'title' => 'Add People',
            'auth' => $auth,
        ));  
    }
    
    public function _search_to_add($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        
        $userService = \Timesheet\User\Service::getInstance();
        $query = $request->getParam('q');
        $ids = $request->getParam('ids');
        
        if (!isset($ids[0]) || empty($ids[0]) || empty($ids)) {
            $data = $userService->getUserByName($query);
        } else {
            $data = $userService->getUserByNameExcept($query, $ids);
        }
        
        $data = \Database\Converter::getArray($data);
        $logger->info(print_r($data,1));
        $this->_response->setBody(array(
            'users' => $data,
            'image_location' => UPLOADS . 'user_images\\'
        ));
    }


}//end class

?>
