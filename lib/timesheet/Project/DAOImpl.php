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
	
    public function searchByNameUnderUserId($projectName, $userId) {
        $valArr = array(
            ':projectName' => $projectName,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find project by name under user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function searchByNameUnderManagerId($projectName, $userId) {
        $valArr = array(
            ':projectName' => $projectName,
            ':projectManagerId' => $userId
        );
        return $this->_executeObjectQuery('find project by name created under user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
	public function getAllProjects() {
        return $this->_executeObjectQuery('get all projects', null, \Native5\Core\Database\DB::SELECT);
	}
	public function getProjectManagerId($projectId) {
        $valArr = array(
            ':projectId' => $projectId
        );
        $data = $this->_executeQuery('get manager id', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['manager_id'];
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
            ':projectManagerId' => $userId
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
    
    public function getEmployeeTotalWorkTime($userId, $projectId) {
        $valArr = array(
            ':projectId' => $projectId,
            ':userId' => $userId,
        );
        $data = $this->_executeQuery('get employee total work time', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['total_work_time'];
    }
    public function getEmployeeTotalPauseTime($userId, $projectId) {
        $valArr = array(
            ':projectId' => $projectId,
            ':userId' => $userId,
        );
        $data = $this->_executeQuery('get employee total pause time', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['total_pause_time'];
    }
	
	public function getProjectNameById($projectId) {
	    $valArr = array(
            ':projectId' => $projectId,
        );
        $data = $this->_executeQuery('get project name by id', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['project_name'];
	}
    
    public function getProjectState($projectId) {
        $valArr = array(
            ':projectId' => $projectId,
        );
        $data = $this->_executeQuery('get project state', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['project_state'];
    }
    
    
    public function getProjectsIncomplete($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get projects incomplete', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function getProjectsComplete($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get projects complete', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function getProjectsOverdue($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get projects overdue', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getAllProjectsOfUser($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get all projects of user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    
    public function searchByNameUnderIncomplete($projectName, $userId) {
        $valArr = array(
            ':projectName' => $projectName,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find project by name under user incomplete', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function searchByNameUnderComplete($projectName, $userId) {
        $valArr = array(
            ':projectName' => $projectName,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find project by name under user complete', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    public function searchByNameUnderOverdue($projectName, $userId) {
        $valArr = array(
            ':projectName' => $projectName,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find project by name under user overdue', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function searchAllProjects($projectName, $userId) {
        $valArr = array(
            ':projectName' => $projectName,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('search all projects of user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
	// WRITE FUNCTIONS
	
	public function createProject($projectDetails) {
	    $valArr = array(
            ':projectName' => $projectDetails->getProjectName(),
            ':projectDescription' => $projectDetails->getProjectDescription(),
            ':projectTimeAlloted' => $projectDetails->getProjectTimeAlloted(),
            ':projectCreatedDate' => $projectDetails->getProjectCreatedDate(),
            ':projectManagerId' => $projectDetails->getProjectManagerId(),
            ':projectSalary' =>$projectDetails->getProjectSalary(),
            ':projectState' => 0,
        );
        
        try {
            return $this->_executeQuery('create new project', $valArr, \Native5\Core\Database\DB::INSERT);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function markCompleted($projectId) {
        try {
            $valArr = array(
                ':projectState' => 1,
                ':projectId' => $projectId
            );
            return $this->_executeQuery('mark complete', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            $GLOBALS['logger']->info($e->getMessage());
            return false;
        }
	}
	
	public function editProject($projectDetails) {
	    $valArr = array(
            ':projectId' => $projectDetails->getProjectId(),
            ':projectName' => $projectDetails->getProjectName(),
            ':projectDescription' => $projectDetails->getProjectDescription(),
            ':projectTimeAlloted' => $projectDetails->getProjectTimeAlloted(),
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
	
	public function addUsersToProject($projectId, $userIds, $notification = null) {
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
            
            $notificationService = \Timesheet\Notification\Service::getInstance();
            $notificationService->createNotification($notification, true);
            
            $this->db->commitTransaction();
        
        } catch (\Exception $e) {
            $GLOBALS['logger']->info('ERROR AT PROJECT IMPL : ' . $e->getMessage());
            $this->db->rollbackTransaction();
            return false;
            
        } 
        
        return true;
	}
	
	public function getProjectTotalWorkTime($projectId) {
	    $valArr = array(
            ':projectId' => $projectId
        );
        
        $data = $this->_executeQuery('get project total work time', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['total_project_work_time'];
	}
	
}