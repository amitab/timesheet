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
class TimesheetsController extends DefaultController
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
            'project_name' => $projectName
        );
        $this->_response->setBody($response); 
    }
    
    public function _new_task($request)
    {
        global $logger;
        $skeleton =  new TwigRenderer('newtask.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $this->_response->setBody(array(
            'title' => 'New Task',
            'form_save' => true,
        )); 
    }
    
    public function _edit_task($request) {
        global $logger;
        $skeleton =  new TwigRenderer('newtask.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        if($request->getParam('id') == null) {
            return;
        } else {
            $id = $request->getParam('id');
        }
        
        $taskService = \Timesheet\Task\Service::getInstance();
        $task = $taskService->getTaskById($id);
        $task = $task[0];
        
        $this->_response->setBody(array(
            'title' => 'Edit Task',
            'form_save' => true,
            'task' => $task,
            'edit' => true
        )); 
    }
    
    public function _search($request) {
        global $logger;
        $this->_response = new HttpResponse('json');
        
        $timesheetService = \Timesheet\Timesheet\Service::getInstance();
        $taskImpl = new \Timesheet\Task\DAOImpl();
        
        $month = date('m');
        
        if($request->getParam('q')!=null) {
            $query = $request->getParam('q');
            $temp = $timesheetService->getTimesheetsUnderProjectName($query); // convert to user specific
        } else if($request->getParam('default') == true) {
            $temp = $timesheetService->getTimesheetsInMonth($month); // convert to user specific
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
            $month = date('M', $date);
            
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
        
        if($request->getParam('id') == null) {
            return;
        } else {
            $id = $request->getParam('id');
        }
        
        $taskService  = \Timesheet\Task\Service::getInstance();
        
        $task = $taskService->getTaskById($id);
        $task = $task[0];
        $title = $task->getTaskName();
        
        
        
        $this->_response->setBody(array(
            'title' => $title,
            'task' =>$task
        )); 
    }

}//end class

?>
