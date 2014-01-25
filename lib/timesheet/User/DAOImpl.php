<?php

namespace Timesheet\User;

class DAOImpl extends \Database\DBService implements \Timesheet\User\DAO {
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
        
        parent::setObjectMaker('\Timesheet\User\User', 'make');
    }
	
	// READ FUNCTIONS
	
	public function getAllUsers() {
        return $this->_executeObjectQuery('get all users', null, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getUserById($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        $data = $this->_executeObjectQuery('find user by id', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data;
	} 
	
    public function getUserByName($userName) {
		$valArr = array(
            ':userName' => $userName
        );
        return $this->_executeObjectQuery('find user by name', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getUserByNameExcept($userName, $userIds) {
        $valArr = array(
            ':userName' => $userName
        );
        
        $sql = 'SELECT `user`.* FROM `user` WHERE `user`.`user_name` LIKE :userName AND `user`.`user_id` NOT IN(';
        $sql .= implode(', ', $userIds);
        $sql .= ');';
        
        return $this->_executeObjectQueryString($sql, $valArr, \Native5\Core\Database\DB::SELECT);
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
    
    public function getUserByPhoneNumber($userPhoneNumber) {
        $valArr = array(
            ':userPhoneNumber' => $userPhoneNumber
        );
        return $this->_executeObjectQuery('find user by phone number', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getUserImageUrl($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        $data = $this->_executeQuery('find user image url', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['image_url'];
    }
	
	// WRITE FUNCTIONS
	
	public function createUser($userDetails) {
	    $valArr = array(
            ':userName' => $userDetails->getUserName(),
            ':userMail' => $userDetails->getUserMail(),
            ':userLocation' => $userDetails->getUserLocation(),
            ':userPhoneNumber' => $userDetails->getUserPhoneNumber(),
            ':userImageUrl' => $userDetails->getUserImageUrl(),
            ':userSex' => $userDetails->getUserSex()
        );
        
        try {
            return $this->_executeQuery('create new user', $valArr, \Native5\Core\Database\DB::INSERT);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function editUser($userDetails) {
	    $userArr = array(
            ':userId' => $userDetails->getUserId(),
            ':userName' => $userDetails->getUserName(),
            ':userMail' => $userDetails->getUserMail(),
            ':userLocation' => $userDetails->getUserLocation(),
            ':userPhoneNumber' => $userDetails->getUserPhoneNumber(),
            ':userSex' => $userDetails->getUserSex()
        );
        
        try {
            return $this->_executeQuery('edit user', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function editUserPassword($userId, $password) {
	    $userArr = array(
            ':userId' => $userId,
            ':password' => $password,
        );
        
        try {
            return $this->_executeQuery('edit user password', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function deleteUser($userId) {
	    $valArr = array(
            ':userId' => $userId
        );
    
        try {
            return $this->_executeQuery('delete user', $valArr, \Native5\Core\Database\DB::DELETE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function uploadUserImage($imageUrl, $userId) {
        $valArr = array(
            ':userId' => $userId,
            ':imageUrl' => $imageUrl
        );
    
        try {
            return $this->_executeQuery('update user image', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function removeUserImage($userId) {
        $valArr = array(
            ':userId' => $userId,
            ':imageUrl' => 'default.jpg'
        );
        
        $data = $this->_executeQuery('select user image url', $valArr, \Native5\Core\Database\DB::SELECT);
        if(!$data) { return false; }
        
        unlink(UPLOAD_PATH . $data[0]['user_image_url']);
        
        try {
            return $this->_executeQuery('update user image', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
    }
	
}