<?php

namespace Timesheet\Group;

class DAOImpl extends \Native5\Core\Database\DBDAO implements \Timesheet\Group\DAO {
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
	
	public function createGroup($groupDetails) {
	    $valArr = array(
            ':groupName' => $groupDetails->getGroupName()
        );
        return $this->_executeObjectQuery('create new group', $valArr, \Native5\Core\Database\DB::INSERT);
	}
	
	public function editGroup($groupDetails) {
	    $valArr = array(
            ':groupId' => $groupDetails->getGroupId(),
            ':groupName' => $groupDetails->getGroupName()
        );
        
        return $this->_executeObjectQuery('edit group', $valArr, \Native5\Core\Database\DB::UPDATE);
	}
	
	public function deleteGroup($groupId) {
	    $valArr = array(
            ':groupId' => $groupId
        );
        return $this->_executeObjectQuery('delete group', $valArr, \Native5\Core\Database\DB::DELETE);
	}
	
	public function getUsersGroup($userId) {
	    $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get group of user', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	// Executors
	
	private function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = \Timesheet\Group\Group::make($res); 
        } 

        return $results;
	}
	
	private function _executeQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;
        
        return $temp_results;
	}
}