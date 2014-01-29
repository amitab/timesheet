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
	
    public function createUser($userDetails) {
        return $this->_dao->createUser($userDetails);
    }
    public function editUser($userDetails) {
        return $this->_dao->editUser($userDetails);
    }
    public function deleteUser($userId) {
        return $this->_dao->deleteUser($userId);
    }
    public function editUserPassword($userId, $password) {
        return $this->_dao->editUserPassword($userId, $password);
    }
	
	public function getUsersForProject($userName, $projectId, $userIds=null) {
	    return $this->_dao->getUsersForProject($userName, $projectId, $userIds);
	}
	
	public function getUserById($userId) {
		$data = $this->_dao->getUserById($userId);
		return $data;
	}
	
	private function count_digit($number) {
        return strlen($number);
    }
	
	public function getUserStats($userId) {
	    $hours = round($this->_dao->getTotalUserWorkHours($userId)/3600);
	    $data = array(
	        'timesheets' => $this->_dao->getUserTimesheetCount($userId),
	        'projects' => $this->_dao->getUserProjectCount($userId),
	        'hours' => $hours,
	    );
	    return $data;
	}
	
	public function getTotalUserWorkHours($userId) {
	    return ($this->_dao->getTotalUserWorkHours($userId))/3600;
	}
	
	public function getAllUsers() {
	    return $this->_dao->getAllUsers();
	}
    public function getUsersUnderProjectId($projectId) {
        return $this->_dao->getUsersUnderProjectId($projectId);
    }
    public function getUsersUnderProjectName($projectName) {
        return $this->_dao->getUsersUnderProjectName($projectName);
    }
    public function getUserByName($userName) {
        return $this->_dao->getUserByName($userName);
    }
	public function getUserProjectCount($userId) {
	    return $this->_dao->getUserProjectCount($userId);
	}
	public function getUserTimesheetCount($userId) {
	    return $this->_dao->getUserTimesheetCount($userId);
	}
	public function getUserHourCount($userId) {
	    return $this->_dao->getUserHourCount($userId);
	}
    public function getUsersUnderGroup($group) {
	    return $this->_dao->getUsersUnderGroup($group);
    }
    public function getUserByNameExcept($userName, $userIds) {
        return $this->_dao->getUserByNameExcept($userName, $userIds);
    }
	
    public function getUserByPhoneNumber($userPhoneNumber) {
        return $this->_dao->getUserByPhoneNumber($userPhoneNumber);
    }
    public function getUserImageUrl($userId) {
        return $this->_dao->getUserImageUrl($userId);
    }
    public function getUserNameById($userId) {
        return $this->_dao->getUserNameById($userId);
    }
    public function uploadUserImage($imageUrl, $userId) {
        return $this->_dao->uploadUserImage($imageUrl, $userId);
    }
    public function removeUserImage($userId) {
        return $this->_dao->removeUserImage($userId);
    }
}