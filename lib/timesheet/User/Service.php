<?php

namespace Timesheet\User;

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
        $this->_dao = new \Timesheet\User\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// The Cover
	
	public function getUserById($userId) {
		$data = $_dao->getUserById($userId);
		return $data;
	}
	
	public function getUserStats($userId) {
	    $data = array(
	        'timesheets' => $_dao->getUserTimesheetCount($userId),
	        'projects' => $_dao->getUserProjectCount($userId),
	        'hours' => $_dao->getUserHourCount($userId)
	    );
	    return $data;
	}
	
	public function getAllUsers() {
	    return $_dao->getAllUsers();
	}
    public function getUsersUnderProjectId($projectId) {
        return $_dao->getUsersUnderProjectId($projectId);
    }
    public function getUsersUnderProjectName($projectName) {
        return $_dao->getUsersUnderProjectName($projectName);
    }
    public function getUserByName($userName) {
        return $_dao->getUserByName($userName);
    }
	public function getUserProjectCount($userId) {
	    return $_dao->getUserProjectCount($userId);
	}
	public function getUserTimesheetCount($userId) {
	    return $_dao->getUserTimesheetCount($userId);
	}
	public function getUserHourCount($userId) {
	    return $_dao->getUserHourCount($userId);
	}
	
}