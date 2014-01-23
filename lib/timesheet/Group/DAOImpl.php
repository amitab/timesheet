<?php

namespace Timesheet\Group;

class DAOImpl extends \Database\DBService implements \Timesheet\Group\DAO {
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
        parent::setObjectMaker('\Timesheet\Group\Group', 'make');
    }
	
	// WRITE FUNCTIONS
	
	public function createGroup($groupDetails) {
	    $valArr = array(
            ':groupName' => $groupDetails->getGroupName()
        );
        
        try {
            return $this->_executeQuery('create new group', $valArr, \Native5\Core\Database\DB::INSERT);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function editGroup($groupDetails) {
	    $valArr = array(
            ':groupId' => $groupDetails->getGroupId(),
            ':groupName' => $groupDetails->getGroupName()
        );
        
        try {
            return $this->_executeQuery('edit group', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function deleteGroup($groupId) {
	    $valArr = array(
            ':groupId' => $groupId
        );
        
        try {
            return $this->_executeQuery('delete group', $valArr, \Native5\Core\Database\DB::DELETE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	// READ FUNCTIONS
	
	public function getUsersGroup($userId) {
	    $valArr = array(
            ':userId' => $userId
        );
        
        return $this->_executeObjectQuery('get group of user', $valArr, \Native5\Core\Database\DB::SELECT);
	}
}