<?php

namespace Timesheet\Project;

class DAOImpl extends \Database\DBService implements \Timesheet\Project\DAO {
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
        parent::setObjectMaker('\Timesheet\Project\Project', 'make');
    }
	
	// READ FUNCTIONS
	
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
	
    public function getProjectsWithSalaryGreaterThan($projectSalary) {
		$valArr = array(
            ':projectSalary' => $projectSalary
        );
        return $this->_executeObjectQuery('get project with salary greater than', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getProjectsWithSalaryLessThan($projectSalary) {
		$valArr = array(
            ':projectSalary' => $projectSalary
        );
        return $this->_executeObjectQuery('get project with salary less than', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getProjectOfTimesheet($timesheetId) {
		$valArr = array(
            ':timesheetId' => $timesheetId
        );
        return $this->_executeObjectQuery('get project of timesheet', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
	// WRITE FUNCTIONS
	
	public function createProject($projectDetails) {
	    $valArr = array(
            ':projectName' => $projectDetails->getProjectName(),
            ':projectDescription' => $projectDetails->getProjectDescription(),
            ':projectStatus' => $projectDetails->getProjectStatus(),
            ':projectTimeAlloted' => $projectDetails->getProjectTimeAlloted(),
            ':projectCreatedDate' => $projectDetails->getProjectCreatedDate(),
            ':projectManagerId' => $projectDetails->getProjectManagerId(),
            ':projectSalary' =>$projectDetails->getProjectSalary(),
        );
        
        try {
            return $this->_executeQuery('create new project', $valArr, \Native5\Core\Database\DB::INSERT);
        } catch (\Exception $e) {
            return false;
        }
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
        
        try {
            return $this->_executeQuery('edit project', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function deleteProject($projectDetails) {
	    $valArr = array(
            ':projectId' => $projectDetails->getProjectId()
        );
        
        try {
            return $this->_executeQuery('delete project', $valArr, \Native5\Core\Database\DB::DELETE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	// Admin Functions
	
	public function addUsersToProject($projectId, $userIds) {
	    try {
        
            $this->db->beginTransaction();
            
            // SQL FOR INSERTING INTO USER_PROJECT TABLE (1:N RELATIONSHIP)
            $sql = 'INSERT INTO `user_project` (project_id, user_id) VALUES ';
            $valuesArray = array();
            foreach($userIds as $userId) {
                $valuesArray[] = '(' . $projectId . ', ' . $userId . ')';
            }
            $sql .= implode(', ', $valuesArray);
            $sql .= ';';
            
            parent::tableHasPrimaryKey(false);
            
            $this->_executeQueryString($sql, null, \Native5\Core\Database\DB::INSERT);
            
            $this->db->commitTransaction();
        
        } catch (\Exception $e) {
            
            $this->db->rollbackTransaction();
            return false;
            
        } 
        
        return true;
	}
	
}