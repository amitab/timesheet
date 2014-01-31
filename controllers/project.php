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
            
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        ));      

    }//end _default()
    
    /*public function _created_projects($request)
    {
        global $logger;
        $skeleton =  new TwigRenderer('createdprojects.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $this->_response->setBody(array(
            'title' => 'Projects',
            'search' => true,
            
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        ));      

    }*///end _default()
    
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
        
        $userId = $this->user->getUserId();
        
        // Check if user owns this project or is working for this project
        if($projectData->getProjectManagerId() == $userId) {
            $isAdmin = true;
            $isEmployee = false;
        } else {
            $isAdmin = false;
            $isEmployee = true;
        }
        
        $employerName = $userService->getUserNameById($projectData->getProjectManagerId());
        
        if($isAdmin) {
            $totalTime = $projectService->getProjectTotalWorkTime($id);
            if($totalTime == null) {
                $totalTime = 0;
            } else {
                $totalTime = round($totalTime/3600);  // Converting seconds to hours since money is per hour
            }
            // If admin, get total time spent by all employees and total money spent on the project
            // If employee, get total time spent by him and total salary
            $expenses = $projectData->getProjectSalary() * $totalTime;
        } 
        else if($isEmployee) {
            
            $totalTime = $userService->getTotalTimeSpentByUserOnProject($userId, $id);
            $slackOffTime = $userService->getTotalTimePausedByUserOnProject($userId, $id);
            if($totalTime == null) {
                $totalTime = 0;
            } else {
                $totalTime = round($totalTime/3600);  // Converting seconds to hours since money is per hour
            }
            if($slackOffTime == null) {
                $slackOffTime = 0;
            } else {
                $slackOffTime = round($slackOffTime/3600);  // Converting seconds to hours since money is per hour
            }
            
            $salary = $projectData->getProjectSalary() * $totalTime;
            $expenses = $projectData->getProjectSalary() * $slackOffTime;
        
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
            
        }
            
        
        if((int) $request->getParam('error') == 1) {
            $message['fail'] = 'Error';
        } else if((int) $request->getParam('success') == 1) {
            $message['success'] = 'Success';
        }
        
        $response = array(
            'title' => 'Project Details',
            'is_admin' => $isAdmin,
            'is_employee' => $isEmployee,
            'project_details' => $projectData,
            'expenses' => number_format($expenses), // for employee, salary * pausetime; for employer, salary * total work hours
            'total_time' => $totalTime,
            'pause_time' => $slackOffTime, // for admin null
            'total_salary' => number_format($salary), // for admin null
            'employer_name' => $employerName,
            'project_id' => $id,
            'edit_option' => $isAdmin, // only if user is admin
            'inline_menu' => true,
            'message' => $message,
            
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
        );
        
        $this->_response->setBody($response);  
    }
    
    public function _create_new($request) {
        
        global $logger;
        $skeleton =  new TwigRenderer('createproject.html');
        $this->_response = new HttpResponse('none', $skeleton);
        $userId = $this->user->getUserId(); // Get current User
        // Also check if user is admin else kick
        
        if($request->getParam('new') != null) {
            $project = new \Timesheet\Project\Project();
            $createdDate = new DateTime('now');
            $projectName = trim($request->getParam('project_name'));
            if(!$projectName) {
                $message['fail'][] = 'Project name can\'t be empty.';
            } else {
                $project->setProjectName($projectName);
            }
            
            $deadline = trim($request->getParam('deadline'));
            if(!$deadline) {
                $message['fail'][] = 'Deadline date can\'t be empty.';
            } else {
                $deadlineDate = new DateTime($deadline);
                
                if(strtotime($deadline) <= strtotime('now')) {
                    $message['fail'][] = 'Deadline date can\'t be in the past!';
                } else {
                    $project->setProjectTimeAlloted($deadlineDate->format('Y-m-d H:i:s'));
                }
            }
            
            $salary = intval($request->getParam('salary'));
            $logger->info('SALARY : ' . $salary);
            if(!$salary) {
                $message['fail'][] = 'Salary input is invalid.';
            } else {
                $project->setProjectSalary($request->getParam('salary'));
            }
            
            $description = $request->getParam('description');
            if(!$description) {
                $project->setProjectDescription('No description given.');
            } else {
                $project->setProjectDescription($description);
            }
            
            $project->setProjectCreatedDate($createdDate->format('Y-m-d H:i:s'));
            $project->setProjectManagerId($userId);
            
            // Insert
            
            if(!isset($message['fail'])) {
                $projectService = \Timesheet\Project\Service::getInstance();
                $projectId = $projectService->createProject($project);
                if($projectId) {
                    $message['success'] = 'Project successfuly created.';
                    $this->_response->redirectTo('project/details?id=' . $projectId);
                } else {
                    $message['fail'] = 'Project could not be created.';
                }
            }
            
        }
        
        $this->_response->setBody(array(
            'title' => 'New Project',
            'form_save' => true,
            'message' => $message,
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        ));  
    }
    
    public function _edit_project($request) {
        global $logger;
        $skeleton =  new TwigRenderer('createproject.html');
        $this->_response = new HttpResponse('none', $skeleton);
        $userId = $this->user->getUserId();
        $projectService = \Timesheet\Project\Service::getInstance();
        
        // Check if user owns this project else kick
        
        if($request->getParam('edit') != null) {
            
            $projectId = intval($request->getParam('project_id'));
            if($projectId > 0) {
                $project = $projectService->getProjectById($projectId);
                $project = $project[0];
                
                $createdDate = new DateTime($project->getProjectCreatedDate());
                $projectName = trim($request->getParam('project_name'));
                if(!$projectName) {
                    $message['fail'][] = 'Project name can\'t be empty.';
                } else {
                    $project->setProjectName($projectName);
                }
                
                $deadline = trim($request->getParam('deadline'));
                if(!$deadline) {
                    $message['fail'][] = 'Deadline date can\'t be empty.';
                } else {
                    $deadlineDate = new DateTime($deadline);
                    
                    if(strtotime($deadline) <= strtotime('now')) {
                        $message['fail'][] = 'Deadline date can\'t be in the past!';
                    } else {
                        $project->setProjectTimeAlloted($deadlineDate->format('Y-m-d H:i:s'));
                    }
                }
                
                $salary = intval($request->getParam('salary'));
                $logger->info('SALARY : ' . $salary);
                if(!$salary) {
                    $message['fail'][] = 'Salary input is invalid.';
                } else {
                    $project->setProjectSalary($request->getParam('salary'));
                }
                
                $description = $request->getParam('description');
                if(!$description) {
                    $project->setProjectDescription('No description given.');
                } else {
                    $project->setProjectDescription($description);
                }
                
                $project->setProjectCreatedDate($createdDate->format('Y-m-d H:i:s'));
                $project->setProjectManagerId($userId);
                
                if(!isset($message['fail'])) {
                    if($projectService->editProject($project)) {
                        $message['success'] = 'Project successfuly updated.';
                        $this->_response->redirectTo('project/details?id=' . $projectId);
                    } else {
                        $message['fail'] = 'Project could not be updated.';
                    }
                }
                
            } else {
                // Id does not exist
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
            'message' => $message,
            
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        ));  
    }
    
    public function _add_users($request) {
        
        global $logger;
        $userId = $this->user->getUserId();
        // Check if user owns this project else kick
        
        if($request->getParam('add_users') != null) {
            $userIds = $request->getParam('ids');
            $projectId = $request->getParam('project_id');
            
            $notification = new \Timesheet\Notification\Notification();
            $notification->setNotificationFromUser($userId);
            $notification->setNotificationPriority(1);
            $notification->setNotificationType(0);
            $today = new DateTime('now');
            $notification->setNotificationDate($today->format('Y-m-d H:i:s'));
            $notification->setNotificationToUser($userIds);
            $notification->setNotificationSubjectId($projectId);
            $projectService = \Timesheet\Project\Service::getInstance();
            $notification->setNotificationBody('You\'ve been requested to join ' . $projectService->getProjectNameById($projectId));
            
            if($projectService->addUsersToProject($projectId, $userIds, $notification)) {
                $success = true;
                $message['response'] = "Users successfully added";
                $message['redirect'] = 'team_list?rand_token=' . $GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce');
                $logger->info('added');
            } else {
                $success = false;
                $message['response'] = "Could not add users. Please try again later.";
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
                'project_id' => $request->getParam('id'),
                
                'email' => $this->user->getUserMail(),
                'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
                'image' => IMAGE_PATH . $this->user->getUserImageUrl()
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
        $projectId = $request->getParam('project_id');
        
        if (!isset($ids[0]) || empty($ids[0]) || empty($ids)) {
            $data = $userService->getUsersForProject($query, $projectId);
        } else {
            $data = $userService->getUsersForProject($query, $projectId, $ids);
        }
        
        $data = \Database\Converter::getArray($data);
        
        if(empty($data)) {
            $reason = 'Person may already be a part of your project or doesn\'t exist.';
        }
        
        $this->_response->setBody(array(
            'users' => $data,
            'image_location' => IMAGE_PATH,
            'thumb_image_location' => THUMB_IMAGE_PATH,
            'reason' => $reason
        ));
    }
    
    public function _search($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        
        $query = $request->getParam('q');
        $userId = $this->user->getUserId(); // Get current user
        $projectService = \Timesheet\Project\Service::getInstance();
        
        /*if($request->getParam('getWorking') != null) {
            // if employee use this. else get projects created by user id
            
            if(!empty($query)) {
                $data = $projectService->searchByNameUnderUserId($query, $userId);
            } else {
                $data = $projectService->getProjectsHandledByUserId($userId);
            }
            
        } else if($request->getParam('getCreated') != null) {
            if(!empty($query)) {
                $data = $projectService->searchByNameUnderManagerId($query, $userId);
            } else {
                $data = $projectService->getProjectsCreatedByUserId($userId);
            }
        } else return;*/
        
        $option = (int) $request->getParam('option');
        $query = $request->getParam('q');
        
        switch($option) {
            case 0: // All
                if(!empty($query)) {
                    $data = $projectService->searchAllProjects($query, $userId);
                } else {
                    $data = $projectService->getAllProjectsOfUser($userId);
                }
            break;
            
            case 1: // Created
                if(!empty($query)) {
                    $data = $projectService->searchByNameUnderManagerId($query, $userId);
                } else {
                    $data = $projectService->getProjectsCreatedByUserId($userId);
                }
            break;
            
            case 2: // Working For
                if(!empty($query)) {
                    $data = $projectService->searchByNameUnderUserId($query, $userId);
                } else {
                    $data = $projectService->getProjectsHandledByUserId($userId);
                }
            break;
            
            case 3: // Completed
                if(!empty($query)) {
                    $data = $projectService->searchByNameUnderComplete($query, $userId);
                } else {
                    $data = $projectService->getProjectsComplete($userId);
                }
            break;
            
            case 4: // In Progress
                if(!empty($query)) {
                    $data = $projectService->searchByNameUnderIncomplete($query, $userId);
                } else {
                    $data = $projectService->getProjectsIncomplete($userId);
                }
            break;
            
            case 5: // Overdue
                if(!empty($query)) {
                    $data = $projectService->searchByNameUnderOverdue($query, $userId);
                } else {
                    $data = $projectService->getProjectsOverdue($userId);
                }
            break;
        }        
        
        $data = \Database\Converter::getArray($data);
        
        $this->_response->setBody(array(
            'projects' => $data,
        ));
    }
    
    public function _mark_complete($request) {
        if($request->getParam('id') == null) {
            return;
        } else {
            $projectId = (int) $request->getParam('id');
            $projectService = \Timesheet\Project\Service::getInstance();
            if($projectService->markCompleted($projectId)) {
                $this->_response->redirectTo('project/details?success=1&id=' . $projectId);
            } else {
                $this->_response->redirectTo('project/details?error=1&id=' . $projectId);
            }
        }
    }
    
    public function _team_list($request) {
        global $logger;
        $skeleton =  new TwigRenderer('teamlist.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        if($request->getParam('id') == null) {
            return;
        } else {
            $projectId = (int) $request->getParam('id');
            $userService = \Timesheet\User\Service::getInstance();
            $data = $userService->getUsersUnderProjectId($projectId);
        }
        
        $notificationService = \Timesheet\Notification\Service::getInstance();
        $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
        
        $this->_response->setBody(array(
            'title' => 'Team',
            'users' => $data,
            'image_path' => IMAGE_PATH,
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
        )); 
    }

}//end class

?>
