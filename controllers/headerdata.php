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
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
            $headerMenu['notification'] = true;
            $headerMenu['notification_count'] = $notifications;
            break;
            case 'notifications' :
            $headerMenu['refresh'] = true;
            break;
            case 'project/timesheets' :
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
            $headerMenu['notification'] = true;
            $headerMenu['notification_count'] = $notifications;
            break;
            case 'profile/edit_profile' :
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
            $headerMenu['notification'] = true;
            $headerMenu['notification_count'] = $notifications;
            break;
            case 'project/details' :
            
            $projectId = $request->getParam('id');
            $projectService = \Timesheet\Project\Service::getInstance();
            $projectState = $projectService->getProjectState($projectId);
            $managerId = $projectService->getProjectManagerId($projectId);
            $isAdmin = ($this->user->getUserId() == $managerId) ? true: false;
            
            $inlineMenu = array();
            $inlineMenu['View Team'] = 'teamlist.html?id=' . $projectId;
            $inlineMenu['View All Timesheets'] = 'timesheetsunderproject.html?id=' . $projectId;
            $inlineMenu['Back to Projects'] = 'projects-test.html';
            $inlineMenu['Start Working'] = 'timer.html?id=' . $projectId;
			
            if($projectState == 0) {
                if($isAdmin) {
                    $inlineMenu['Add Users'] = 'adduserstoproject.html?id=' . $projectId;
                }
            }
            
            $headerMenu['is_admin'] = $isAdmin;
            $headerMenu['inline_menu'] = true;
            $headerMenu['team_list'] = true;
            $headerMenu['edit'] = $isAdmin;
            $headerMenu['menu'] = $inlineMenu;
            break;
            case 'project/create_new' :
            $headerMenu['form_save'] = true;
            break;
            case 'project/add_users' :
            $headerMenu['search'] = true;
            break;
            case 'project' :
            $headerMenu['search'] = true;
            break;
            case 'project/team_list' :
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
            $headerMenu['notification'] = true;
            $headerMenu['notification_count'] = $notifications;
            break;
            case 'timesheets' :
            $headerMenu['search'] = true;
            break;
            case 'timesheets/details' :
            
            $timesheetId = $request->getParam('timesheet_id');
            $timesheetService = \Timesheet\Timesheet\Service::getInstance();
            $managerId = $timesheetService->getProjectManagerId($timesheetId);
            $isAdmin = ($this->user->getUserId() == $managerId) ? true: false;
            
            $headerMenu['add_task'] = true;
            $headerMenu['is_admin'] = $isAdmin;
            break;
            case 'timesheets/new_task' :
            $headerMenu['form_save'] = true;
            break;
            case 'timesheets/task_details' :
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
            $headerMenu['notification'] = true;
            $headerMenu['notification_count'] = $notifications;
            break;
            case 'timer' :
            $headerMenu['add_task'] = true;
            $headerMenu['timer'] = true;
            break;
            
            default:
            $headerOptions = '';
            break;
            
        }
        
        
        $this->_response->setBody(array(
            'header_menu' => $headerMenu
        ));
        
    }

}//end class

?>
