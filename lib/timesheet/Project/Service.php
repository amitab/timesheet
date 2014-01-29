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
    public function editProject($projectDetails) {
        return $this->_dao->editProject($projectDetails);
    }
    public function deleteProject($projectId) {
        return $this->_dao->deleteProject($projectDetails);
    }
    public function addUsersToProject($projectId, $userIds, $notification=null) {
        return $this->_dao->addUsersToProject($projectId, $userIds, $notification);
    }
    public function markCompleted($projectId) {
        return $this->_dao->markCompleted($projectId);
    }
    
    // read only functions
    public function searchByNameUnderUserId($projectName, $userId) {
        return $this->_dao->searchByNameUnderUserId($projectName, $userId);
    }
    public function getProjectManagerId($projectId) {
        return $this->_dao->getProjectManagerId($projectId);
    }
    public function getProjectNameById($projectId) {
        return $this->_dao->getProjectNameById($projectId);
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
    
    public function getEmployeeTotalWorkTime($userId, $projectId) {
        return $this->_dao->getEmployeeTotalWorkTime($userId, $projectId);
    }
    public function getEmployeeTotalPauseTime($userId, $projectId) {
        return $this->_dao->getEmployeeTotalPauseTime($userId, $projectId);
    }
    public function getProjectTotalWorkTime($projectId) {
        return $this->_dao->getProjectTotalWorkTime($projectId);
    }
	
}