<?php

namespace Timesheet\Authentication;

class DAOImpl extends \Database\DBService implements \Timesheet\Authentication\DAO {
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
        parent::setObjectMaker('\Timesheet\Authentication\Authentication', 'make');
    }
	
	// READ FUNCTIONS
	
	public function getUsersAuthentication($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get users authentication', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	// WRITE FUNCTIONS
	
	public function createAuthentication($authenticationDetails) {
        $valArr = array(
            ':groupId' => $authenticationDetails->getGroupId(),
            ':userId' => $authenticationDetails->getUserId(),
            ':password' => $authenticationDetails->getPassword()
        );
        
        try {
            return $this->_executeQuery('create authentication', $valArr, \Native5\Core\Database\DB::INSERT);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function editAuthentication($authenticationDetails) {
        $valArr = array(
            ':userId' => $authenticationDetails->getUserId(),
            ':password' => $authenticationDetails->getPassword(),
            ':groupId' => $authenticationDetails->getGroupId()
        );
        
        try {
            return $this->_executeQuery('edit authentication', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
	}
}