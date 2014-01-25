<?php

namespace Timesheet\Project;

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
        $this->_dao = new \Timesheet\Project\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// The Cover
	
	// write only functions
    public function createProject($projectDetails) {
        return $this->_dao->createProject($projectDetails);
    }
    public function editProject($projectId) {
        return $this->_dao->editProject($projectDetails);
    }
    public function deleteProject($projectId) {
        return $this->_dao->deleteProject($projectDetails);
    }
    
    // read only functions
    public function searchByNameUnderUserId($projectName, $userId) {
        return $this->_dao->searchByNameUnderUserId($projectName, $userId);
    }
    
    public function getAllProjects() {
        return $this->_dao->getAllProjects();
    }
    public function getProjectById($id) {
        return $this->_dao->getProjectById($id);
    }
    public function getProjectsInMonth($month) {
        return $this->_dao->getProjectsInMonth($month);
    }
    public function getProjectsInYear($year) {
        return $this->_dao->getProjectsInYear($year);
    }
    public function findProjectByName($projectName) {
        return $this->_dao->findProjectByName($projectName);
    }
    public function getProjectsHandledByUserId($userId) {
        return $this->_dao->getProjectsHandledByUserId($userId);
    }
    public function getProjectsCreatedByUserId($userId) {
        return $this->_dao->getProjectsCreatedByUserId($userId);
    }
    public function getProjectsWithSalaryGreaterThan($projectSalary) {
        return $this->_dao->getProjectsWithSalaryGreaterThan($projectSalary);
    }
    public function getProjectsWithSalaryLessThan($projectSalary) {
        return $this->_dao->getProjectsWithSalaryLessThan($projectSalary);
    }
    public function getProjectOfTimesheet($timesheetId) {
        return $this->_dao->getProjectOfTimesheet($timesheetId);
    }
    public function getTotalPauseTime($projectId) {
        $timesheetImpl = new \Timesheet\Timesheet\DAOImpl();
        $pauseTime = 0;
        $timesheets = $timesheetImpl->getTimesheetsUnderProjectId($projectId);
        foreach($timesheets as $timesheet) {
            $pause = $timesheetImpl->getTimesheetPauseTime($timesheet->getTimesheetId());
            if($pause!=false) {
                $pauseTime += $pause;
            }
        }
        return $pauseTime;
    }
    public function getTotalWorkTime($projectId) {
        $timesheetImpl = new \Timesheet\Timesheet\DAOImpl();
        $workTime = 0;
        $timesheets = $timesheetImpl->getTimesheetsUnderProjectId($projectId);
        foreach($timesheets as $timesheet) {
            $work = $timesheetImpl->getTimesheetWorkTime($timesheet->getTimesheetId());
            if($work!=false) {
                $workTime += $work;
            }
        }
        return $workTime;
    }
    public function getTotalSalaryEarned($projectId) {
        $project = $this->getProjectById($projectId);
        $workTime = $this->getTotalWorkTime($projectId);
        return $workTime * $project->getProjectSalary();
    }
    public function getTotalExpense($projectId) {
        $project = $this->getProjectById($projectId);
        $pauseTime = $this->getTotalPauseTime($projectId);
        return $pauseTime * $project->getProjectSalary();
    }
	
}