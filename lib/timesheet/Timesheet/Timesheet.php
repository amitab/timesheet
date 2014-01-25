<? php

namespace Timesheet\Timesheet;

class Timesheet {
    private $timesheetId;
    private $timesheetDate;
    private $timesheetProjectName;
    private $timesheetStatus;
    private $timesheetMarkTime;
    
    private $readableTimesheetStatus;
    
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
	    if ($timesheetStatus == UNMARKED) {
	        $readableTimesheetStatus = 'Not Evaluated';
	    } else if ($timesheetStatus == APPROVED) {
	        $readableTimesheetStatus = 'Approved';
	    } else if ($timesheetStatus == REJECTED) {
	        $readableTimesheetStatus = 'Rejected';
	    }
	}

}