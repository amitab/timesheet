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
class TimesheetsController extends \My\Control\ProtectedController
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
        $skeleton =  new TwigRenderer('timesheets.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $this->_response->setBody(array(
            'title' => 'Timesheets',
            'search' =>true,
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        ));  

    }
    
    public function _details($request) {
        global $logger;
        $skeleton =  new TwigRenderer('sheetdetails.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        if($request->getParam('id') == null) {
            return;
        } else {
            $id = $request->getParam('id');
        }
        
        $taskService = \Timesheet\Task\Service::getInstance();
        $timesheetService = \Timesheet\Timesheet\Service::getInstance();
        
        $tasks = $taskService->getAllTasksOfTimesheet($id);
        $timesheet = $timesheetService->getTimesheetById($id);
        $timesheet = $timesheet[0];
        $date = $timesheet->makeAndGetDate();
        $title = date('M', $date) . ' ' . date('Y', $date) . ', Week ' . date('W', $date);
        $projectName = $timesheet->getTimesheetProjectName();
        
        $response = array(
            'title' => $title,
            'add_task' => true,
            'timesheet' => $timesheet,
            'tasks' => $tasks,
            'project_name' => $projectName,
            'project_id' => $timesheetService->getTimesheetProjectId($id),
            'timesheet_id' => $id,
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        );
        $this->_response->setBody($response); 
    }
    
    private function _validate($request) {
        $taskName = trim($request->getParam('task_name'));
        if(!$taskName) {
            $message['fail'][] = 'Task name is invalid.';
        }
        $startDate = strtotime($request->getParam('start_time'));
        $endDate =  strtotime($request->getParam('end_time'));
        if($startDate >= $endDate) {
            $message['fail'][] = 'You could\'t have started the task in the past!';
        }
        return $message;
    }
    
    public function _new_task($request) 
    {
        global $logger;
        $skeleton =  new TwigRenderer('newtask.html');
        $this->_response = new HttpResponse('none', $skeleton);
        $timesheetService = \Timesheet\Timesheet\Service::getInstance();
        $taskService = \Timesheet\Task\Service::getInstance();
        $userId = $this->user->getUserId();
        $projectId = (int)$request->getParam('project_id');
        $projectService = \Timesheet\Project\Service::getInstance();
        $projectName = $projectService->getProjectNameById($projectId);
        
        if($request->getParam('new') != null) {
            
            $message = $this->_validate($request);
            if(!isset($message['fail'])) {
            
                $task = new \Timesheet\Task\Task();
                $task->setTaskName($request->getParam('task_name'));
                $dateObject = new DateTime($request->getParam('start_time'));
                $task->setTaskStartTime($dateObject->format('Y-m-d H:i:s'));
                $dateObject = new DateTime($request->getParam('end_time'));
                $task->setTaskEndTime($dateObject->format('Y-m-d H:i:s'));
                
                $notification = new \Timesheet\Notification\Notification();
                $notification->setNotificationFromUser($userId);
                $notification->setNotificationPriority(1);
                $notification->setNotificationType(1);
                $today = new DateTime('now');
                $notification->setNotificationDate($today->format('Y-m-d H:i:s'));
                $notification->setNotificationToUser(array($projectService->getProjectManagerId($projectId)));
                
                $notification->setNotificationBody('A new Task was added to ' . $projectName . '.');
                
                $task->setNotification($notification);
                
                if($request->getParam('work_time') != null) {
                    $task->setTaskWorkTime($request->getParam('work_time'));
                    $workTime = $task->getTaskWorkTime();
                } else {
                    $startTime = strtotime($request->getParam('start_time'));
                    $endTime = strtotime($request->getParam('end_time'));
                    $task->setTaskWorkTime($endTime - $startTime);
                }
                
                $location = trim($request->getParam('location'));
                if(!$location) {
                    $task->setTaskLocation('Location Unknown.');
                } else {
                    $task->setTaskLocation($request->getParam('location'));
                }
                
                $notes = trim($request->getParam('notes'));
                if(!$notes) {
                    $task->setTaskLocation('No notes written by user.');
                } else {
                    $task->setTaskLocation($request->getParam('notes'));
                }
                
                // If new task being added to old timesheet
                if($request->getParam('timesheet_id') != null) { 
                    
                    $timesheetId = (int) $request->getParam('timesheet_id');
                    if($taskService->createTask($task, $timesheetId, false)) {
                        $message['success'] = 'New Task created.';
                        $this->_response->redirectTo('timesheets/details?id=' . $timesheetId);
                    } else {
                        $message['fail'] = 'Task could not be created.';
                    }
                } 
                // Timesheet for this project this week present already
                else if($timesheetId = $timesheetService->findThisWeekTimesheet($userId, $projectId)) { 
                    $logger->info('Found Timesheet for this week.');
                    if($taskService->createTask($task, $timesheetId, false)) {
                        $message['success'] = 'New Task created.';
                        $this->_response->redirectTo('timesheets/details?id=' . $timesheetId);
                    } else {
                        $message['fail'] = 'Task could not be created.';
                    }
                    
                } 
                // Make new timesheet and task in it
                else {  
                    
                    $logger->info('Creating Timesheet for this week.');
                    
                    $timesheet = new \Timesheet\Timesheet\Timesheet();
                    $projectService = \Timesheet\Project\Service::getInstance();
                    $timesheet->setTimesheetProjectName($projectService->getProjectNameById($projectId));
                    $timesheet->setUserId($userId);
                    $timesheet->setProjectId($projectId);
                    $now = new DateTime('now');
                    $timesheet->setTimesheetDate($now->format('Y-m-d'));
                    
                    $timesheetId = $timesheetService->createTimesheetAndTask($timesheet, $task);
                    if($timesheetId) {
                        $message['success'] = 'New Task created.';
                        $logger->info('Created.');
                        $this->_response->redirectTo('timesheets/details?id=' . $timesheetId);
                    } else {
                        $message['fail'] = 'Task could not be created.';
                    }
                    
                }
            
            }
            
        }
        
        // collect common parameters
        if($request->getParam('project_id') != null) {
            $getParamProjectId = $request->getParam('project_id');
        } else {
            $getParamProjectId = 0;
        }
        
        // collect parameters from the timesheet details page
        if($request->getParam('from_timesheet_details_page') != null) {
            $coming_from_timesheet_details_page = true;
            
            if($request->getParam('old_timesheet_id') != null) {
                $getParamId = $request->getParam('old_timesheet_id');
            } else {
                $getParamId = 0;
            }
        }
        
        // collect parameters from the timer page
        if($request->getParam('from_timer_page') != null) {
            
            $coming_from_timer_page = true;
            
            if($request->getParam('work_time') != null) {
                $getParamWorkTime = $request->getParam('work_time');
            } else {
                $getParamWorkTime = 0;
            }
            if($request->getParam('start_time') != null) {
                $getParamStartTime = $request->getParam('start_time');
            } else {
                $getParamStartTime = 0;
            }
            if($request->getParam('end_time') != null) {
                $getParamEndTime = $request->getParam('end_time');
            } else {
                $getParamEndTime = 0;
            }
        }
        
        $response = array(
            'title' => 'New Task',
            'form_save' => true,
            'message' => $message,
            
            'coming_from_timer_page' => $coming_from_timer_page,
            'coming_from_timesheet_details_page' => $coming_from_timesheet_details_page,
            
            // sent values from timesheet details page
            'old_timesheet_id' => $getParamId,
            // sent values from timer page
            'sent_work_time' => $getParamWorkTime,
            'sent_start_time' => $getParamStartTime,
            'sent_end_time' => $getParamEndTime,
            // common parameters
            'sent_project_id' => $getParamProjectId,
            'project_name' =>$projectName,
            
            //If for some reason creation of new task failed. Restore the worktime
            'work_time' => $workTime,
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        );
        
        $this->_response->setBody($response); 
    }
    
    /*public function _edit_task($request) {
        global $logger;
        $skeleton =  new TwigRenderer('newtask.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        if($request->getParam('id') == null) {
            return;
        } else {
            $projectService = \Timesheet\Project\Service::getInstance();
            $id = $request->getParam('id');
            $projectName = $projectService->getProjectNameById($id);
        }
        
        $taskService = \Timesheet\Task\Service::getInstance();
        
        if($request->getParam('edit') != null) {
            
            $task = new \Timesheet\Task\Task();
            $task->setTaskName($request->getParam('task_name'));
            $dateObject = new DateTime($request->getParam('start_time'));
            $task->setTaskStartTime($dateObject->format('Y-m-d H:i:s'));
            $dateObject = new DateTime($request->getParam('end_time'));
            $task->setTaskEndTime($dateObject->format('Y-m-d H:i:s'));
            
            $startTime = strtotime($request->getParam('start_time'));
            $endTime = strtotime($request->getParam('end_time'));
            $task->setTaskWorkTime($endTime - $startTime);
            
            $task->setTaskLocation($request->getParam('location'));
            $task->setTaskNotes($request->getParam('notes'));
            
            if($taskService->editTask($task)) {
                $message['success'] = 'Task successfuly edited.';
            } else {
                $message['fail'] = 'Task could not be edited.';
            }
        }
        
        $task = $taskService->getTaskById($id);
        $task = $task[0];
        
        $this->_response->setBody(array(
            'title' => 'Edit Task',
            'form_save' => true,
            'task' => $task,
            'edit' => true,
            'message' => $message,
            'project_name' =>$projectName,
        )); 
    }*/
    
    public function _search($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        
        $timesheetService = \Timesheet\Timesheet\Service::getInstance();
        $taskImpl = new \Timesheet\Task\DAOImpl();
        
        $userId = $this->user->getUserId(); // Get user id
        
        if($request->getParam('q')!=null) {
            $query = $request->getParam('q');
            $temp = $timesheetService->getUserTimesheetsUnderProjectName($query, $userId);
        } else if($request->getParam('default') == true) {
            if($request->getParam('offset') !=null ) {
                $offset = (int)$request->getParam('offset');
                $temp = $timesheetService->getUserAllTimesheets($userId, $offset);
            } else {
                $temp = $timesheetService->getUserAllTimesheets($userId);
            }
        } else {
            return false;
        }
        
        $data = array();
            
        foreach($temp as $timesheet) {
            $ddate = $timesheet->getTimesheetDate();
            $duedt = explode("-", $ddate);
            $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
            $week  = (int)date('W', $date);
            $year  = (int)date('Y', $date);
            
            $time = $taskImpl->getTotalWorkTimeOfTimesheet($timesheet->getTimesheetId());
            if($time) {
                $timesheet->setTimesheetDuration($time);
            } else {
                $timesheet->setTimesheetDuration(0);
            }
            
            $timesheet = \Database\Converter::getSingleArray($timesheet);
            $data[$year][$week][] = $timesheet;
        }
            
        $this->_response->setBody(array(
            'tables' => $data
        ));
    }
    
    public function _task_details($request) {
        global $logger;
        $skeleton =  new TwigRenderer('taskdetails.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $userId = $this->user->getUserId();
        
        if($request->getParam('mark') != null) {
            
            $markValue = (int) $request->getParam('mark');
            $taskId = (int) $request->getParam('id');
            
            $returnValue = $this->_mark_task($taskId, $markValue);
            if($returnValue) {
                $message['success'] = 'An Error occured.';
            } else {
                $message['fail'] = 'Task successfuly marked!';
            }
        } 
        
        if($request->getParam('id') == null) {
            return;
        } else {
            $id = $request->getParam('id');
        }        
        
        $taskService  = \Timesheet\Task\Service::getInstance();
        $timesheetService  = \Timesheet\Timesheet\Service::getInstance();
        
        $task = $taskService->getTaskById($id);
        $task = $task[0];
        
        $managerId = $timesheetService->getProjectManagerId($task->getTaskTimesheetId());
        $logger->info('MANAGER : ' . $managerId);
        if($managerId == $userId) {
            $isAdmin = true;
        } else {
            $isAdmin = false;
        }
        
        $title = $task->getTaskName();
        
        $notificationService = \Timesheet\Notification\Service::getInstance();
        $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
        
        $this->_response->setBody(array(
            'title' => $title,
            'task' => $task,
            'is_admin' => $isAdmin,
            'message' => $message,
            
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
        )); 
    }
    
    private function _mark_task($taskId, $markValue) {
        global $logger;
        
        $taskService  = \Timesheet\Task\Service::getInstance();
        if($taskService->markTask($taskId, $markValue)) {
            $logger->info('DONE');
        } else {
            $logger->info('NOT DONE');
        }
    }

}//end class

?>
