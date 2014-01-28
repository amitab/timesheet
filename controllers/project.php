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
class ProjectController extends \My\Control\ProtectedController
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
        
        $this->_response->setBody(array(
            'title' => 'Projects',
            'search' =>true,
        ));      

    }//end _default()
    
    public function _details($request) {
        
        global $logger;
        $skeleton =  new TwigRenderer('projectdetails.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $projectService = \Timesheet\Project\Service::getInstance();
        $taskService = \Timesheet\Task\Service::getInstance();
        $userService = \Timesheet\User\Service::getInstance();
        $id = $request->getParam('id');
        $projectData = $projectService->getProjectById($id);
        $projectData = $projectData[0];
        
        $employerName = $userService->getUserNameById($projectData->getProjectManagerId());
        $totalTime = $projectService->getProjectTotalWorkTime($id);
        if($totalTime == null) {
            $totalTime = 0;
        } else {
            $totalTime = $totalTime/3600;  // Converting seconds to hours since money is per hour
        }
        // If admin, get total time spent by all employees and total money spent on the project
        // If employee, get total time spent by him and total salary
        $expenses = $projectData->getProjectSalary() * $totalTime;
        
        $response = array(
            'title' => 'Project Details',
            'is_admin' => true,
            'is_employee' => false,
            'project_details' => $projectData,
            'expenses' => $expenses, // for employee, salary * pausetime; for employer, salary * total work hours
            'total_time' => $totalTime,
            'pause_time' => null, // for admin null
            'total_salary' => null, // for admin null
            'employer_name' => $employerName,
            'project_id' => $id,
            'edit_option' => true // only if user is admin
        );
        
        
        $this->_response->setBody($response);  
    }
    
    public function _create_new($request) {
        
        global $logger;
        $skeleton =  new TwigRenderer('createproject.html');
        $this->_response = new HttpResponse('none', $skeleton);
        $userId = 1;
        
        if($request->getParam('new') != null) {
            $project = new \Timesheet\Project\Project();
            $project->setProjectName($request->getParam('project_name'));
            
            $dateObject = new DateTime($request->getParam('deadline'));
            
            $project->setProjectTimeAlloted($dateObject->format('Y-m-d H:i:s'));
            $project->setProjectSalary($request->getParam('salary'));
            $project->setProjectDescription($request->getParam('description'));
            
            $dateObject = new DateTime('now');
            
            $project->setProjectCreatedDate($dateObject->format('Y-m-d H:i:s'));
            $project->setProjectStatus($request->getParam('status'));
            $project->setProjectManagerId($userId);
            
            // Insert
            
            $projectService = \Timesheet\Project\Service::getInstance();
            if($projectService->createProject($project)) {
                $message['success'] = 'Project successfuly created.';
            } else {
                $message['fail'] = 'Project could not be created.';
            }
            
        }
        
        $this->_response->setBody(array(
            'title' => 'New Project',
            'form_save' => true,
            'message' => $message
        ));  
    }
    
    public function _edit_project($request) {
        global $logger;
        $skeleton =  new TwigRenderer('createproject.html');
        $this->_response = new HttpResponse('none', $skeleton);
        $userId = 1;
        $projectService = \Timesheet\Project\Service::getInstance();
        
        if($request->getParam('edit') != null) {
            $project = new \Timesheet\Project\Project();
            $project->setProjectId($request->getParam('project_id'));
            $project->setProjectName($request->getParam('project_name'));
            
            $dateObject = new DateTime($request->getParam('deadline'));
            
            $project->setProjectTimeAlloted($dateObject->format('Y-m-d H:i:s'));
            $project->setProjectSalary($request->getParam('salary'));
            $project->setProjectDescription($request->getParam('description'));
            
            $project->setProjectStatus($request->getParam('status'));
            $project->setProjectManagerId($userId);
            
            // Update
            
            if($projectService->editProject($project)) {
                $message['success'] = 'Project successfuly updated.';
            } else {
                $message['fail'] = 'Project could not be updated.';
            }
            
        }
        
        if($request->getparam('id') == null) {
            return;
        } else {
            $id = $request->getparam('id');
        }
        
        $editproject = $projectService->getProjectById($id);
        $editproject = $editproject[0];
        
        $this->_response->setBody(array(
            'title' => 'Edit Project',
            'form_save' => true,
            'edit' => true,
            'project' => $editproject,
            'message' => $message
        ));  
    }
    
    public function _add_users($request) {
        
        global $logger;
        
        if($request->getParam('add_users') != null) {
            $userIds = $request->getParam('ids');
            $projectId = $request->getParam('project_id');
            
            $projectService = \Timesheet\Project\Service::getInstance();
            if($projectService->addUsersToProject($projectId, $userIds)) {
                $success = true;
                $message = "Users successfully added";
                $logger->info('added');
            } else {
                $success = false;
                $message = "Could not add users. You are a problem.";
                $logger->info('fail');
            }
            
            $this->_response = new HttpResponse('json');
            $this->_response->setBody(array(
                'success' => $success,
                'info' => $message,
            ));  
            
        } else {
            $skeleton =  new TwigRenderer('adduserstoproject.html');
            $this->_response = new HttpResponse('none', $skeleton);
            $this->_response->setBody(array(
                'title' => 'Add People',
                'search' =>true,
                'project_id' => $request->getParam('id')
            ));  
        }
        
    }
    
    public function _search_to_add($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        
        if ($request->getParam('q') == null ) {
            return;
        }
        
        $userService = \Timesheet\User\Service::getInstance();
        $query = $request->getParam('q');
        $ids = $request->getParam('ids');
        
        if (!isset($ids[0]) || empty($ids[0]) || empty($ids)) {
            $data = $userService->getUserByName($query);
        } else {
            $data = $userService->getUserByNameExcept($query, $ids);
        }
        
        $data = \Database\Converter::getArray($data);
        
        $this->_response->setBody(array(
            'users' => $data,
            'image_location' => IMAGE_PATH
        ));
    }
    
    public function _search($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        
        $query = $request->getParam('q');
        $userId = 12;
        $projectService = \Timesheet\Project\Service::getInstance();
        
        if(!empty($query)) {
            // if employee search projects handled by him. Else search projects handled by him
            $data = $projectService->searchByNameUnderUserId($query, $userId);
        }
        else if($request->getParam('default') == true) {
            // if employee use this. else get projects created by user id
            $data = $projectService->getProjectsHandledByUserId($userId);
        }
        else return;
        
        $data = \Database\Converter::getArray($data);
        
        $this->_response->setBody(array(
            'projects' => $data,
        ));
    }


}//end class

?>
