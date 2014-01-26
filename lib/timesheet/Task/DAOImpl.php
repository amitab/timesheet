<?php

namespace Timesheet\Task;

class DAOImpl extends \Database\DBService implements \Timesheet\Task\DAO {
	const QUERIES_FILE = 'queries.cfg.yml';
	
	public function __construct(\Native5\Core\Database\DB $db = null) {
        // Initialize the database connection
        if (!empty($db))
            parent::__construct($db);
        else
            // Read settings.yml using the application configuration wrapper
            parent::setDBFromConfigurationArray($GLOBALS['app']->getConfiguration()->getRawConfiguration('database'));

        // Load the sql queries file
        parent::loadQueries(__DIR__.DIRECTORY_SEPARATOR.self::QUERIES_FILE);
        parent::setObjectMaker('\Timesheet\Task\Task', 'make');
    }
	
	// READ FUNCTIONS
	
    public function getTotalWorkTimeOfTimesheet($timesheetId) {
        $valArr = array(
            ':timesheetId' => $timesheetId
        );
        $data = $this->_executeQuery('find total work time of timesheet', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['total_work_time'];
    }
    
    public function getTotalPauseTimeOfTimesheet($timesheetId) {
        $valArr = array(
            ':timesheetId' => $timesheetId
        );
        $data = $this->_executeQuery('find total pause time of timesheet', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['total_pause_time'];
    }
	
    public function getAllTasksOfTimesheet($timesheetId) {
        $valArr = array(
            ':timesheetId' => $timesheetId
        );
        return $this->_executeObjectQuery('find all tasks of timesheet', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function getTaskById($taskId) {
        $valArr = array(
            ':taskId' => $taskId
        );
        return $this->_executeObjectQuery('find task by id', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function getTaskByName($taskName) {
        $valArr = array(
            ':taskName' => $taskName
        );
        return $this->_executeObjectQuery('find task by name', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function getTaskUnderProjectByName($taskName, $projectId) {
        $valArr = array(
            ':taskName' => $taskName,
            ':projectId' => $projectId
        );
        return $this->_executeObjectQuery('find task by name under project', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function getTaskUnderTimesheetByName($taskName, $timesheetId) {
        $valArr = array(
            ':taskName' => $taskName,
            ':timesheetId' => $timesheetId
        );
        return $this->_executeObjectQuery('find task by name under timesheet', $valArr, \Native5\Core\Database\DB::SELECT);
    }
	
	// WRITE FUNCTIONS
	
	public function createTask($task, $timesheetId = null, $call = false) {
	    try {
	        $timesheetId == null ? $timesheetId = $task->getTaskTimesheetId() : 1;
            $valArr = array(
                ':taskName' => $task->getTaskName(),
                ':taskNotes' => $task->getTaskNotes(),
                ':taskStartTime' =>$task->getTaskStartTime(),
                ':taskEndTime' =>$task->getTaskEndTime(),
                ':taskTimesheetId' => $timesheetId,
                ':taskWorkTime' => $task->getTaskWorkTime(),
                ':taskLocation' => $task->getTaskLocation()
            );
            
            return $this->_executeObjectQuery('create new task', $valArr, \Native5\Core\Database\DB::INSERT);
            
	    } catch (\Exception $e) {
	        if($call) {
	            throw new \Exception($e->getMessage());
	        } else return false;
	    }
	    
	}
	
	public function deleteTask($taskId) {
	    try {
            $valArr = array(
                ':taskId' => $taskId,
            );
            return $this->_executeObjectQuery('delete task', $valArr, \Native5\Core\Database\DB::DELETE);
	    } catch (\Exception $e) {
	        return false;
	    }
	}
    
    public function editTask($task) {
        try {
            $valArr = array(
                ':taskId' => $task->getTaskId(),
                ':taskName' => $task->getTaskName(),
                ':taskNotes' => $task->getTaskNotes(),
                ':taskStartTime' =>$task->getTaskStartTime(),
                ':taskEndTime' =>$task->getTaskEndTime(),
                ':taskTimesheetId' => $timesheetId,
                ':taskWorkTime' =>$task->getTaskWorkTime(),
                ':taskLocation' => $task->getTaskLocation()
            );
            return $this->_executeObjectQuery('edit task', $valArr, \Native5\Core\Database\DB::UPDATE);
	    } catch (\Exception $e) {
	        return false;
	    }
    }
	
}