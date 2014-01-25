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
    public function getRecentlyMarkedTimesheets($offset) {
        return $this->_dao->getRecentlyMarkedTimesheets($offset);
    }
	
	public function getApprovedTimesheets($offset = 0, $limit = 10) {
	    return $this->_dao->getTimesheetsWithStatus(\Timesheet\Timesheet\APPROVED, $offset, $limit);
	}
	
	public function getRejectedTimesheets($offset = 0, $limit = 10) {
	    return $this->_dao->getTimesheetsWithStatus(\Timesheet\Timesheet\REJECTED, $offset, $limit);
	}
    
    public function getUnmarkedTimesheets($offset = 0, $limit = 10) {
        return $this->_dao->getTimesheetsWithStatus(\Timesheet\Timesheet\UNMARKED, $offset, $limit);
    }
    
    public function markTimesheet($status, $timesheetId, $timesheetMarkTime) {
        if($status != /Timesheet/Timesheet/APPROVED || $status != /Timesheet/Timesheet/REJECTED) {
            return false;
        }
        else {
            return $this->_dao->markTimesheet($status, $timesheetId, $timesheetMarkTime);
        }
    }
	
}