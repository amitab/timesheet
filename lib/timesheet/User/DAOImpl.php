<?php

namespace Timesheet\User;

class DAOImpl extends \Native5\Core\Database\DBDAO implements \Timesheet\User\DAO {
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
    }
	
	// Data Transaction Functions
	
	public function getAllUsers() {
        return $this->_executeObjectQuery('get all users', null, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getUserById($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find user by id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getUserByName($userName) {
		$valArr = array(
            ':userName' => $userName
        );
        return $this->_executeObjectQuery('find user by name', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getUsersUnderProjectId($projectId) {
		$valArr = array(
            ':projectId' => $projectId
        );
        return $this->_executeObjectQuery('get all users under project id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getUsersUnderProjectName($projectName) {
		$valArr = array(
            ':projectName' => $projectName
        );
        return $this->_executeObjectQuery('get all users under project name', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
	public function getUserProjectCount($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        $data = $this->_executeQuery('get number of projects', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['project_count'];
	}
	
	public function getUserTimesheetCount($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        $data = $this->_executeQuery('get number of timesheets', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['timesheet_count'];
	}
	
	public function getUserHourCount($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        $data = $this->_executeQuery('get number of hours', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['hour_count'];
	}
	
	public function getUsersUnderGroup($group) {
	    if(isset($group['groupName'])) {
            
            $valArr = array(
                ':groupName' => $group['groupName']
            );
            return $this->_executeObjectQuery('find users under group name', $valArr, \Native5\Core\Database\DB::SELECT);
            
	    } else if (isset($group['groupId'])) {
	    
	        $valArr = array(
                ':groupId' => $group['groupId']
            );
            return $this->_executeObjectQuery('find users under group id', $valArr, \Native5\Core\Database\DB::SELECT);
	    
	    }
	}
	
	public function createUser($userDetails) {
	    $valArr = array(
            ':userName' => $userDetails->getUserName(),
            ':userMail' => $userDetails->getUserMail(),
            ':userLocation' => $userDetails->getUserLocation()
        );
        return $this->_executeObjectQuery('create new user', $valArr, \Native5\Core\Database\DB::INSERT);
	}
	
	public function editUser($userDetails) {
	    $userArr = array(
            ':userId' => $userDetails->getUserId(),
            ':userName' => $userDetails->getUserName(),
            ':userMail' => $userDetails->getUserMail(),
            ':userLocation' => $userDetails->getUserLocation(),
            ':password' => $userDetails->getUserAuthentication()->getPassword()
        );
	}
	
	public function deleteUser($userId) {
	    $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('delete user', $valArr, \Native5\Core\Database\DB::DELETE);
	}
	
	// Executors
	
	private function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$classReference = \Timesheet\User\User;
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = $classReference::make($res); 
            return $results;
        } else {
            return $temp_results;
        }
	}
	
	private function _executeQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;
        
        return $temp_results;
	}
	
}