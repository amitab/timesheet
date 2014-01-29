<?php

namespace Timesheet\Timesheet;

class Timesheet {
    private $timesheetId;
    private $timesheetDate;
    private $timesheetProjectName;
    
    private $userId;  // Set whenever necessary
    private $userName;  // Set whenever necessary
    private $projectId; // Set whenever necessary
    
    private $timesheetDuration;  // Set whenever necessary
    
    public static function make($data) {
        $timesheet = new self();
        
        $timesheet->setTimesheetId($data['timesheet_id']);
        $timesheet->setTimesheetDate($data['timesheet_date']);
        $timesheet->setTimesheetProjectName($data['timesheet_project_name']);
        
        return $timesheet;
    }
    
    public function setTimesheetDuration($timesheetDuration) { $this->timesheetDuration = $timesheetDuration; }
    public function getTimesheetDuration() { return $this->timesheetDuration; }
    
    public function setTimesheetDate($timesheetDate) { $this->timesheetDate = $timesheetDate; }
    public function getTimesheetDate() { return $this->timesheetDate; }
    
    public function setTimesheetId($timesheetId) { $this->timesheetId = $timesheetId; }
    public function getTimesheetId() { return $this->timesheetId; }
    public function setTimesheetProjectName($timesheetProjectName) { $this->timesheetProjectName = $timesheetProjectName; }
    public function getTimesheetProjectName() { return $this->timesheetProjectName; }
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