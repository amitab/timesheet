<?php

namespace Timesheet\Timesheet;

class Timesheet {
    private $timesheetId;
    private $timesheetDate;
    private $timesheetProjectName;
    private $timesheetStatus;
    private $timesheetMarkTime;
    
    private $readableTimesheetStatus;
    
    private $userId;  // Set whenever necessary
    private $userName;  // Set whenever necessary
    private $projectId; // Set whenever necessary
    
    private $timesheetDuration;  // Set whenever necessary
    
    const UNMARKED = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    
    public static function make($data) {
        $timesheet = new self();
        
        $timesheet->setTimesheetId($data['timesheet_id']);
        $timesheet->setTimesheetDate($data['timesheet_date']);
        $timesheet->setTimesheetProjectName($data['timesheet_project_name']);
        $timesheet->setTimesheetStatus($data['timesheet_status']);
        $timesheet->setTimesheetMarkTime($data['timesheet_mark_time']);
        
        return $timesheet;
    }
    
    public function setTimesheetDuration($timesheetDuration) { $this->timesheetDuration = $timesheetDuration; }
    public function getTimesheetDuration() { return $this->timesheetDuration; }
    
    public function setTimesheetDate($timesheetDate) { $this->timesheetDate = $timesheetDate; }
    public function getTimesheetDate() { return $this->timesheetDate; }
    public function setTimesheetMarkTime($timesheetMarkTime) { $this->timesheetMarkTime = $timesheetMarkTime; }
    public function getTimesheetMarkTime() { return $this->timesheetMarkTime; }
    
    public function setTimesheetId($timesheetId) { $this->timesheetId = $timesheetId; }
    public function getTimesheetId() { return $this->timesheetId; }
    public function setTimesheetProjectName($timesheetProjectName) { $this->timesheetProjectName = $timesheetProjectName; }
    public function getTimesheetProjectName() { return $this->timesheetProjectName; }
	public function getTimesheetStatus() { return $this->timesheetStatus; }
	public function setTimesheetStatus($timesheetStatus) { 
	    $this->timesheetStatus = $timesheetStatus; 
	    if ($timesheetStatus == self::UNMARKED) {
	        $readableTimesheetStatus = 'Not Evaluated';
	    } else if ($timesheetStatus == self::APPROVED) {
	        $readableTimesheetStatus = 'Approved';
	    } else if ($timesheetStatus == self::REJECTED) {
	        $readableTimesheetStatus = 'Rejected';
	    }
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($userId){
		$this->userId = $userId;
	}
	
	public function getProjectId(){
		return $this->projectId;
	}

	public function setProjectId($projectId){
		$this->projectId = $projectId;
	}

	public function getUserName(){
		return $this->userName;
	}

	public function setUserName($userName){
		$this->userName = $userName;
	}
	
	public function makeAndGetDate() {
        $ddate = $this->getTimesheetDate();
        $duedt = explode("-", $ddate);
        $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
        return $date;
    }

}