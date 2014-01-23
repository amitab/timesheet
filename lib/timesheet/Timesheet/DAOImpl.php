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
            ':timesheetId' => $ustimesheetIderId
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
                ':status' => /Timesheet/Timesheet/UNMARKED,
            );
            return $this->_executeObjectQuery('get recently marked timesheets', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    } else {
	        
	        $valArr = array(
                ':offset' => $offset,
            );
            return $this->_executeObjectQuery('get recently marked timesheets with offset', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    }
	}
	
	public function getTimesheetsWithStatus($timesheetStatus, $offset, $limit) {
	    $valArr = array(
            ':timesheetStatus' => $timesheetStatus,
            ':limit' => $limit,
            ':offset' => $offset
        );
        return $this->_executeObjectQuery('get timesheets with status', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetWorkTime($timesheetId) {
	    $valArr = array(
            ':timesheetId' => $timesheetId,
        );
        
        $data = $this->_executeQuery('get timesheet work time', $valArr, \Native5\Core\Database\DB::SELECT);
        if($data == false) return false;
        else return $data[0]['work_time'];
    }
    public function getTimesheetPauseTime($timesheetId) {
	    $valArr = array(
            ':timesheetId' => $timesheetId,
        );
        $data = $this->_executeQuery('get timesheet pause time', $valArr, \Native5\Core\Database\DB::SELECT);
        if($data == false) return false;
        else return $data[0]['pause_time'];
    }
	
	// WRITE FUNCTIONS
	
	public function createTimesheet($timesheetDetails) {
	    $valArr = array(
            ':timesheetStartTime' => $timesheetDetails->getTimesheetStartTime(),
            ':timesheetEndTime' => $timesheetDetails->getTimesheetEndTime(),
            ':timesheetDescription' => $timesheetDetails->getTimesheetDescription(),
            ':timesheetLocation' => $timesheetDetails->getTimesheetLocation(),
            ':timesheetTask' => $timesheetDetails->getTimesheetTask(),
            ':timesheetProjectName' => $timesheetDetails->getTimesheetProjectName(),
            ':timesheetStatus' => $timesheetDetails->getTimesheetStatus(),
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
            
            $this->db->rollbackTransaction();
            return false;
            
        } 
        
        return true;
	}
	
	public function editTimesheet($timesheetDetails) {
	    $valArr = array(
            ':timesheetId' => $timesheetDetails->getTimesheetId(),
            ':timesheetStartTime' => $timesheetDetails->getTimesheetStartTime(),
            ':timesheetEndTime' => $timesheetDetails->getTimesheetEndTime(),
            ':timesheetDescription' => $timesheetDetails->getTimesheetDescription(),
            ':timesheetLocation' => $timesheetDetails->getTimesheetLocation(),
            ':timesheetTask' => $timesheetDetails->getTimesheetTask(),
            ':timesheetProjectName' => $timesheetDetails->getTimesheetProjectName(),
            ':timesheetStatus' => $timesheetDetails->getTimesheetStatus(),
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