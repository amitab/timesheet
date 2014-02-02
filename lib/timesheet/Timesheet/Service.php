<?php

namespace Timesheet\Timesheet;

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
        $this->_dao = new \Timesheet\Timesheet\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// The Cover
	public function getAuthorOfTimesheet($timesheetId) {
	    $data = $this->_dao->getAuthorOfTimesheet($timesheetId);
	    return $data;
	}
	public function getProjectManagerId($timesheetId) {
	    return $this->_dao->getProjectManagerId($timesheetId);
	}
	public function getTimesheetProjectId($timesheetId) {
	    return $this->_dao->getTimesheetProjectId($timesheetId);
	}
	public function createTimesheetAndTask($timesheetDetails, $task) {
	    return $this->_dao->createTimesheetAndTask($timesheetDetails, $task);
	}
	public function findThisWeekTimesheet($userId, $projectId) {
        return $this->_dao->findThisWeekTimesheet($userId, $projectId);
    }
    
    public function createTimesheet($timesheetDetails) {
        return $this->_dao->createTimesheet($timesheetDetails);
    }
    public function editTimesheet($timesheetDetails) {
        return $this->_dao->editTimesheet($timesheetDetails);
    }
    public function deleteTimesheet($timesheetId) {
        return $this->_dao->deleteTimesheet($timesheetId);
    }

    public function getTimesheetById($timesheetId) {
        return $this->_dao->getTimesheetById($timesheetId);
    }
    public function getTimesheetsUnderProjectId($projectId) {
        return $this->_dao->getTimesheetsUnderProjectId($projectId);
    }
    public function getTimesheetsUnderProjectName($projectName) {
        return $this->_dao->getTimesheetsUnderProjectName($projectName);
    }
    public function getAllTimesheets() {
        return $this->_dao->getAllTimesheets();
    }
    public function getTimesheetsInMonth($month) {
        return $this->_dao->getTimesheetsInMonth($month);
    }
    public function getTimesheetsInYear($year) {
        return $this->_dao->getTimesheetsInYear($year);
    }
    public function getTimesheetsInMonthWeek($month, $week) {
        return $this->_dao->getTimesheetsInMonthWeek($month, $week);
    }
    
    // User specific read
    
    public function getUserTimesheetsUnderProjectId($projectId, $userId) {
        return $this->_dao->getUserTimesheetsUnderProjectId($projectId, $userId);
    }
    public function getUserTimesheetsUnderProjectName($projectName, $userId) {
        return $this->_dao->getUserTimesheetsUnderProjectName($projectName, $userId);
    }
    public function getUserAllTimesheets($userId, $offset=null) {
        return $this->_dao->getUserAllTimesheets($userId, $offset);
    }
    public function getUserTimesheetsInMonth($month, $userId) {
        return $this->_dao->getUserTimesheetsInMonth($month, $userId);
    }
    public function getUserTimesheetsInYear($year, $userId) {
        return $this->_dao->getUserTimesheetsInYear($year, $userId);
    }
    public function getUserTimesheetsInMonthWeek($month, $week, $userId) {
        return $this->_dao->getUserTimesheetsInMonthWeek($month, $week, $userId);
    }
    public function getUserTimesheetsWithStatus($timesheetStatus, $limit, $offset, $userId) {
        return $this->_dao->getUserTimesheetsWithStatus($timesheetStatus, $limit, $offset, $userId);
    }
	
}