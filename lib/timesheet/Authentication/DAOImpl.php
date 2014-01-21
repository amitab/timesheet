<?php

namespace Timesheet\Authentication;

class DAOImpl extends \Native5\Core\Database\DBDAO implements \Timesheet\Authentication\DAO {
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
	
	public function getUsersAuthentication($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get users authentication', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	public function createAuthentication($authenticationDetails) {
        $valArr = array(
            ':groupId' => $authenticationDetails->getGroupId(),
            ':userId' => $authenticationDetails->getUserId(),
            ':password' => $authenticationDetails->getPassword()
        );
        return $this->_executeObjectQuery('create authentication', $valArr, \Native5\Core\Database\DB::INSERT);
	}
	
	public function editAuthentication($authenticationDetails) {
        $valArr = array(
            ':userId' => $authenticationDetails->getUserId(),
            ':password' => $authenticationDetails->getPassword(),
            ':groupId' => $authenticationDetails->getGroupId()
        );
        return $this->_executeObjectQuery('edit authentication', $valArr, \Native5\Core\Database\DB::UPDATE);
	}
	
	// Executors
	
	private function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = \Timesheet\Authentication\Authentication::make($res); 
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