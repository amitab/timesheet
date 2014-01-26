<?php

namespace Timesheet\Task;

class Service {
	private $_data;
    private $_dao;

    /**
     * 
     * @var Singleton
     */
    private static $instance;

    private function __construct() {
        global $logger;
        $this->_data = array();
        $this->_dao = new \Timesheet\Task\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// The Cover
	
    public function createTask($task, $timesheetId, $call) {
        return $this->_dao->createTask($task, $timesheetId, $call);
    }
    public function deleteTask($taskId) {
        return $this->_dao->deleteTask($taskIdtask, $timesheetId, $call);
    }
    public function editTask($task) {
        return $this->_dao->editTask($task);
    }
    
    // read only
    
    public function getAllTasksOfTimesheet($timesheetId) {
        return $this->_dao->getAllTasksOfTimesheet($timesheetId);
    }
    public function getTaskById($taskId) {
        return $this->_dao->getTaskById($taskId);
    }
    public function getTaskByName($taskName) {
        return $this->_dao->getTaskByName($taskName);
    }
    public function getTaskUnderProjectByName($taskName, $projectId) {
        return $this->_dao->getTaskUnderProjectByName($taskName, $projectId);
    }
    public function getTaskUnderTimesheetByName($taskName, $timesheetId) {
        return $this->_dao->getTaskUnderTimesheetByName($taskName, $timesheetId);
    }
    public function getTotalWorkTimeOfTimesheet($timesheetId) {
        return $this->_dao->getTotalWorkTimeOfTimesheet($timesheetId);
    }
    public function getTotalPauseTimeOfTimesheet($timesheetId) {
        return $this->_dao->getTotalPauseTimeOfTimesheet($timesheetId);
    }
	
}