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
class HeaderdataController extends \My\Control\ProtectedController
{


    /**
     * _default 
     * 
     * @param mixed $request Request to use
     *
     * @access public
     * @return void
     */    
    public function _default($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        $renderer =  new TwigRenderer('header-options.html');
        
        switch($request->getParam('for')) {
            case 'profile' :
            $headerOptions = $renderer->render(array());
            break;
            case 'notifications' :
            $headerOptions = $renderer->render(array('refresh' => true));
            break;
            case 'project/timesheets' :
            $headerOptions = $renderer->render(array());
            break;
            case 'project/details' :
            
            $projectId = $request->getParam('project_id');
            $projectService = \Timesheet\Project\Service::getInstance();
            $managerId = $projectService->getProjectManagerId($projectId);
            $isAdmin = ($this->user->getUserId() == $managerId) ? true: false;
            $headerOptions = $renderer->render(array(
                'is_admin' => $isAdmin,
                'edit_option' => $isAdmin, // only if user is admin
                'inline_menu' => true,
            ));
            break;
            case 'project/create_new' :
            $headerOptions = $renderer->render(array('form_save' => true));
            break;
            case 'project/add_users' :
            $headerOptions = $renderer->render(array('search' => true));
            break;
            case 'project' :
            $headerOptions = $renderer->render(array('search' => true));
            break;
            case 'project/team_list' :
            $headerOptions = $renderer->render(array());
            break;
            case 'timesheets' :
            $headerOptions = $renderer->render(array('search' => true));
            break;
            case 'timesheets/details' :
            
            $timesheetId = $request->getParam('timesheet_id');
            $timesheetService = \Timesheet\Timesheet\Service::getInstance();
            $managerId = $timesheetService->getProjectManagerId($timesheetId);
            $isAdmin = ($this->user->getUserId() == $managerId) ? true: false;
            
            $headerOptions = $renderer->render(array('add_task' => true, 'is_admin' => $isAdmin));
            break;
            case 'timesheets/new_task' :
            $headerOptions = $renderer->render(array('form_save' => true));
            break;
            case 'timesheets/task_details' :
            $headerOptions = $renderer->render(array());
            break;
            case 'timer' :
            $headerOptions = $renderer->render(array('add_task' => true, 'timer' => true));
            break;
            
            default:
            $headerOptions = '';
            break;
            
        }
        
        
        $this->_response->setBody(array(
            'header_options' => $headerOptions
        ));
        
    }

}//end class

?>
