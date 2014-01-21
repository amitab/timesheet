<?php

namespace Timesheet\Timesheet;

interface DAO {
    // write only functions
    public function createTimesheet($timesheetDetails);
    public function editTimesheet($timesheetId);
    public function deleteTimesheet($timesheetId);

    // read only functions
    public function getTimesheetById($timesheetId);
    public function getTimesheetsUnderProjectId($projectId);
    public function getTimesheetsUnderProjectName($projectName);
    public function getAllTimesheets();
    public function getTimesheetsInMonth($month);
    public function getTimesheetsInYear($year);
    public function getTimesheetsInMonthWeek($month, $week);
    public function getUnmarkedTimesheets($offset);
    public function getRecentlyMarkedTimesheets($offset);
    
}