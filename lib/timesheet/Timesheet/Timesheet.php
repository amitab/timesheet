<? php

namespace Timesheet\Timesheet;

class Timesheet {
    private $timesheetId;
    private $timesheetStartTime;
    private $timesheetEndTime;
    private $timesheetDescription;
    private $timesheetLocation;
    private $timesheetTask;
    private $timesheetProjectName;
    private $timesheetStatus;
    private $readableTimesheetStatus;
    private $timesheetWorkTime;
    private $timesheetMarkTime;
    
    private $userId;
    private $projectId;
    
    const UNMARKED = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    
    public static function make($data) {
        $timesheet = new self();
        
        $timesheet->setTimesheetId($data['timesheet_id']);
        $timesheet->setTimesheetStartTime($data['timesheet_start_time']);
        $timesheet->setTimesheetEndTime($data['timesheet_end_time']);
        $timesheet->setTimesheetDescription($data['timesheet_description']);
        $timesheet->setTimesheetLocation($data['timesheet_location']);
        $timesheet->setTimesheetTask($data['timesheet_task']);
        $timesheet->setTimesheetProjectName($data['timesheet_project_name']);
        $timesheet->setTimesheetStatus($data['timesheet_status']);
        $timesheet->setTimesheetWorkTime($data['timesheet_work_time']);
        $timesheet->setTimesheetMarkTime($data['timesheet_mark_time']);
        
        return $timesheet;
    }
    
    public function setTimesheetWorkTime($timesheetWorkTime) { $this->timesheetWorkTime = $timesheetWorkTime; }
    public function getTimesheetWorkTime() { return $this->timesheetWorkTime; }
    public function setTimesheetMarkTime($timesheetMarkTime) { $this->timesheetMarkTime = $timesheetMarkTime; }
    public function getTimesheetMarkTime() { return $this->timesheetMarkTime; }
    
    public function setUserId($userId) { $this->userId = $userId; }
    public function getUserId() { return $this->userId; }
    public function setProjectId($projectId) { $this->projectId = $projectId; }
    public function getProjectId() { return $this->projectId; }
    
    public function setTimesheetId($timesheetId) { $this->timesheetId = $timesheetId; }
    public function getTimesheetId() { return $this->timesheetId; }
    public function setTimesheetStartTime($timesheetStartTime) { $this->timesheetStartTime = $timesheetStartTime; }
    public function getTimesheetStartTime() { return $this->timesheetStartTime; }
    public function setTimesheetEndTime($timesheetEndTime) { $this->timesheetEndTime = $timesheetEndTime; }
    public function getTimesheetEndTime() { return $this->timesheetEndTime; }
    public function setTimesheetDescription($timesheetDescription) { $this->timesheetDescription = $timesheetDescription; }
    public function getTimesheetDescription() { return $this->timesheetDescription; }
    public function setTimesheetLocation($timesheetLocation) { $this->timesheetLocation = $timesheetLocation; }
    public function getTimesheetLocation() { return $this->timesheetLocation; }
    public function setTimesheetTask($timesheetTask) { $this->timesheetTask = $timesheetTask; }
    public function getTimesheetTask() { return $this->timesheetTask; }
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
	public function

}