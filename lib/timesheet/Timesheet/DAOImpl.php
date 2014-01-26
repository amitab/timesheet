<?php

namespace Timesheet\Timesheet;

class DAOImpl extends \Database\DBService implements \Timesheet\Timesheet\DAO {
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
        parent::setObjectMaker('\Timesheet\Timesheet\Timesheet', 'make');
    }
	
	// READ FUNCTIONS
	
	public function getAllTimesheets() {
        return $this->_executeObjectQuery('get all timesheets', null, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetById($timesheetId) {
		$valArr = array(
            ':timesheetId' => $timesheetId
        );
        return $this->_executeObjectQuery('find timesheet by id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getTimesheetsUnderProjectName($projectName) {
		$valArr = array(
            ':projectName' => $projectName
        );
        return $this->_executeObjectQuery('find timesheets under project name', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getTimesheetsUnderProjectId($projectId) {
		$valArr = array(
            ':projectId' => $projectId
        );
        return $this->_executeObjectQuery('find timesheets under under project id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getTimesheetsInMonth($month) {
		$valArr = array(
            ':month' => $month
        );
        return $this->_executeObjectQuery('find timesheets created in month', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetsInYear($year) {
		$valArr = array(
            ':year' => $year
        );
        return $this->_executeObjectQuery('find timesheets created in year', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetsInMonthWeek($month, $week) {
		$valArr = array(
            ':month' => $month,
            ':week' => $week
        );
        return $this->_executeObjectQuery('find timesheets created in month and week', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	public function getRecentlyMarkedTimesheets($offset = NULL) {
	    if($offset == NULL) {
	        $valArr = array(
                ':status' => \Timesheet\Timesheet\UNMARKED,
            );
            return $this->_executeObjectQuery('get recently marked timesheets', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    } else {
	        
	        $valArr = array(
                ':offset' => $offset,
            );
            return $this->_executeObjectQuery('get recently marked timesheets with offset', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    }
	}
	
	public function getTimesheetsWithStatus($timesheetStatus,$limit, $offset) {
	    $valArr = array(
            ':timesheetStatus' => $timesheetStatus,
            ':limit' => $limit,
            ':offset' => $offset
        );
        return $this->_executeObjectQuery('get timesheets with status', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	// WRITE FUNCTIONS
	
	public function createTimesheet($timesheetDetails) {
	    $valArr = array(
            ':timesheetProjectName' => $timesheetDetails->getTimesheetProjectName(),
            ':timesheetStatus' => 0,
            ':timesheetDate' => $timesheetDetails->getTimesheetDate(),
        );
        
        try {
            
            $this->db->beginTransaction();
            
            // Need current insert ID
            $timesheetId = $this->_executeObjectQuery('create new timesheet', $valArr, \Native5\Core\Database\DB::INSERT); 
            
            // Inserting into the association tables
            $sql = 'INSERT INTO `user_timesheet` (timesheet_id, user_id) VALUES (' . 
            $timesheetId . ', ' . $timesheetDetails->getUserId . ');';
            $sql .= 'INSERT INTO `project_timesheet` (timesheet_id, project_id) ' .
            'VALUES (' . $timesheetId . ', ' . $timesheetDetails->getProjectId . ');';
            
            parent::tableHasPrimaryKey(false);
            $this->_executeQueryString($sql, null, \Native5\Core\Database\DB::INSERT);
            
            $this->db->commitTransaction();
            
        } catch (\Exception $e) {
            $GLOBALS['logger']->info( 'Could not create timesheet' . $e->getMessage());
            $this->db->rollbackTransaction();
            return false;
            
        } 
        
        return true;
	}
	
	
	public function editTimesheet($timesheetDetails) {
	    $valArr = array(
            ':timesheetId' => $timesheetDetails->getTimesheetId(),
            ':timesheetProjectName' => $timesheetDetails->getTimesheetProjectName(),
            ':timesheetDate' => $timesheetDetails->getTimesheetDate(),
        );
        
        try {
            return $this->_executeQuery('edit timesheet', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
	}
	
	public function deleteTimesheet($timesheetId) {
	    $valArr = array(
            ':timesheetId' => $timesheetId
        );
        
        try {
            return $this->_executeQuery('delete timesheet', $valArr, \Native5\Core\Database\DB::DELETE);
        } catch (\Exception $e) {
            return false;
        }
        
        return $result;
	}
	
	// user specific read functions 
	
    public function getUserAllTimesheets($userId) {
        $varArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get all timesheets for user', $varArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getUserTimesheetsUnderProjectName($projectName, $userId) {
		$valArr = array(
            ':projectName' => $projectName,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find timesheets under project name for user', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getUserTimesheetsUnderProjectId($projectId, $userId) {
		$valArr = array(
            ':projectId' => $projectId,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find timesheets under under project id for user', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getUserTimesheetsInMonth($month, $userId) {
		$valArr = array(
            ':month' => $month,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find timesheets created in month for user', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getUserTimesheetsInYear($year, $userId) {
		$valArr = array(
            ':year' => $year,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find timesheets created in year for user', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getUserTimesheetsInMonthWeek($month, $week, $userId) {
		$valArr = array(
            ':month' => $month,
            ':week' => $week,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find timesheets created in month and week for user', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	public function getUserRecentlyMarkedTimesheets($userId, $offset = NULL) {
	    if($offset == NULL) {
	        $valArr = array(
                ':status' => \Timesheet\Timesheet\UNMARKED,
                ':userId' => $userId
                
            );
            return $this->_executeObjectQuery('get recently marked timesheets for user', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    } else {
	        
	        $valArr = array(
                ':offset' => $offset,
                ':userId' => $userId
            );
            return $this->_executeObjectQuery('get recently marked timesheets with offset for user', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    }
	}
	
	public function getUserTimesheetsWithStatus($timesheetStatus, $limit, $userId, $offset = NULL) {
	    $valArr = array(
            ':timesheetStatus' => $timesheetStatus,
            ':limit' => $limit,
            ':offset' => $offset,
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('get timesheets with status for user', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	// project manager functions
    
    public function markTimesheet($status, $timesheetId, $timesheetMarkTime) {
        $valArr = array(
            ':status' => $status,
            ':timesheetId' => $timesheetId,
            ':timesheetMarkTime' => $timesheetMarkTime
        );
        
        try {
            return $this->_executeQuery('mark timesheet', $valArr, \Native5\Core\Database\DB::UPDATE);
        } catch (\Exception $e) {
            return false;
        }
        
        return $result;
    }
}