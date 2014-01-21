<?php

namespace Timesheet\Project;

class DAOImpl extends \Native5\Core\Database\DBDAO implements \Timesheet\Project\DAO {
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
	
	public function getAllProjects() {
        return $this->_executeObjectQuery('get all projects', null, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getProjectById($projectId) {
		$valArr = array(
            ':projectId' => $projectId
        );
        return $this->_executeObjectQuery('find project by id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function findProjectByName($projectName) {
		$valArr = array(
            ':projectName' => $projectName
        );
        return $this->_executeObjectQuery('find project by name', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getProjectsInMonth($month) {
		$valArr = array(
            ':month' => $month
        );
        return $this->_executeObjectQuery('find project created in month', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getProjectsInYear($year) {
		$valArr = array(
            ':year' => $year
        );
        return $this->_executeObjectQuery('find project created in year', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	public function getProjectsHandledByUserId($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get project handled by user id', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	public function getProjectsCreatedByUserId($userId) {
		$valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get project created by user id', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	
	public function createProject($projectDetails) {
	    $valArr = array(
            ':projectName' => $projectDetails->getProjectName(),
            ':projectDescription' => $projectDetails->getProjectDescription(),
            ':projectStatus' => $projectDetails->getProjectStatus(),
            ':projectTimeAlloted' => $projectDetails->getProjectTimeAlloted(),
            ':projectCreatedDate' => $projectDetails->getProjectCreatedDate(),
            ':projectManagerId' => $projectDetails->getProjectManagerId()
        );
        return $this->_executeObjectQuery('create new project', $valArr, \Native5\Core\Database\DB::INSERT);
	}
	
	public function editProject($projectDetails) {
	    $valArr = array(
            ':projectId' => $projectDetails->getProjectId(),
            ':projectName' => $projectDetails->getProjectName(),
            ':projectDescription' => $projectDetails->getProjectDescription(),
            ':projectStatus' => $projectDetails->getProjectStatus(),
            ':projectTimeAlloted' => $projectDetails->getProjectTimeAlloted(),
            ':projectCreatedDate' => $projectDetails->getProjectCreatedDate(),
            ':projectManagerId' => $projectDetails->getProjectManagerId()
        );
        return $this->_executeObjectQuery('edit project', $valArr, \Native5\Core\Database\DB::UPDATE);
	}
	
	public function deleteProject($projectDetails) {
	    $valArr = array(
            ':projectId' => $projectDetails->getProjectId()
        );
        return $this->_executeObjectQuery('delete project', $valArr, \Native5\Core\Database\DB::DELETE);
	}
	
	// Executors
	
	private function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = \Timesheet\Project\Project::make($res); 
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