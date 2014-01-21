<?php

namespace Timesheet\Timesheet;

class DAOImpl extends \Native5\Core\Database\DBDAO implements \Timesheet\Timesheet\DAO {
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
	
	public function getAllTimesheets() {
        return $this->_executeQuery('get all timesheets', null, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetById($timesheetId) {
		$valArr = array(
            ':timesheetId' => $ustimesheetIderId
        );
        return $this->_executeQuery('find timesheet by id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getTimesheetsUnderProjectName($projectName) {
		$valArr = array(
            ':projectName' => $projectName
        );
        return $this->_executeQuery('find timesheets under project name', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getTimesheetsUnderProjectId($projectId) {
		$valArr = array(
            ':projectId' => $projectId
        );
        return $this->_executeQuery('find timesheets under under project id', $valArr, \Native5\Core\Database\DB::SELECT);
	} 
	
    public function getTimesheetsInMonth($month) {
		$valArr = array(
            ':month' => $month
        );
        return $this->_executeQuery('find timesheets created in month', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetsInYear($year) {
		$valArr = array(
            ':year' => $year
        );
        return $this->_executeQuery('find timesheets created in year', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
    public function getTimesheetsInMonthWeek($month, $week) {
		$valArr = array(
            ':month' => $month,
            ':week' => $week
        );
        return $this->_executeQuery('find timesheets created in month and week', $valArr, \Native5\Core\Database\DB::SELECT);
	}
	
	public function getUnmarkedTimesheets($offset = NULL) {
	    if($offset == NULL) {
	        
            return $this->_executeQuery('get unmarked timesheets', null, \Native5\Core\Database\DB::SELECT);
	        
	    } else {
	        
	        $valArr = array(
                ':offset' => $offset,
            );
            return $this->_executeQuery('get unmarked timesheets with offset', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    }
	}
	
	public function getRecentlyMarkedTimesheets($offset = NULL) {
	    if($offset == NULL) {
	        
            return $this->_executeQuery('get recently marked timesheets', null, \Native5\Core\Database\DB::SELECT);
	        
	    } else {
	        
	        $valArr = array(
                ':offset' => $offset,
            );
            return $this->_executeQuery('get recently marked timesheets with offset', $valArr, \Native5\Core\Database\DB::SELECT);
	        
	    }
	}
	
	
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
        return $this->_executeQuery('create new timesheet', $valArr, \Native5\Core\Database\DB::INSERT);
	}
	
	public function editUser($userDetails) {
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
        
        // update password aswell!
        
        return $this->_executeQuery('edit timesheet', $valArr, \Native5\Core\Database\DB::UPDATE);
	}
	
	public function deleteUser($userId) {
	    $valArr = array(
            ':timesheetId' => $timesheetId
        );
        return $this->_executeQuery('delete timesheet', $valArr, \Native5\Core\Database\DB::DELETE);
	}
	
	// Executors
	
	private function _executeQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = \Timesheet\Timesheet\Timesheet::make($res); 
        } else {
            return true;
        }

        return $results;
	}
}