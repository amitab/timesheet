<? php

namespace Timesheet\Timesheet;

class Timesheet {
    private $timesheetId;
    private $timesheetStartTime;
    private $timesheetStartDate;
    private $timesheetEndTime;
    private $timesheetEndDate;
    private $timesheetDescription;
    private $timesheetLocation;
    private $timesheetTask;
    private $timesheetProjectName;
    
    public function setTimesheetId($timesheetId) { $this->timesheetId = $timesheetId; }
    public function getTimesheetId() { return $this->timesheetId; }
    public function setTimesheetStartTime($timesheetStartTime) { $this->timesheetStartTime = $timesheetStartTime; }
    public function getTimesheetStartTime() { return $this->timesheetStartTime; }
    public function setTimesheetStartDate($timesheetStartDate) { $this->timesheetStartDate = $timesheetStartDate; }
    public function getTimesheetStartDate() { return $this->timesheetStartDate; }
    public function setTimesheetEndTime($timesheetEndTime) { $this->timesheetEndTime = $timesheetEndTime; }
    public function getTimesheetEndTime() { return $this->timesheetEndTime; }
    public function setTimesheetEndDate($timesheetEndDate) { $this->timesheetEndDate = $timesheetEndDate; }
    public function getTimesheetEndDate() { return $this->timesheetEndDate; }
    public function setTimesheetDescription($timesheetDescription) { $this->timesheetDescription = $timesheetDescription; }
    public function getTimesheetDescription() { return $this->timesheetDescription; }
    public function setTimesheetLocation($timesheetLocation) { $this->timesheetLocation = $timesheetLocation; }
    public function getTimesheetLocation() { return $this->timesheetLocation; }
    public function setTimesheetTask($timesheetTask) { $this->timesheetTask = $timesheetTask; }
    public function getTimesheetTask() { return $this->timesheetTask; }
    public function setTimesheetProjectName($timesheetProjectName) { $this->timesheetProjectName = $timesheetProjectName; }
    public function getTimesheetProjectName() { return $this->timesheetProjectName; }

}