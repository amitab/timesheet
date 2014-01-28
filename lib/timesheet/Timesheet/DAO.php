<?php

namespace Timesheet\Timesheet;

interface DAO {
    // write only functions
    public function createTimesheet($timesheetDetails);
    public function editTimesheet($timesheetDetails);
    public function deleteTimesheet($timesheetId);
    public function createTimesheetAndTask($timesheetDetails, $task);

    // read only functions
    public function getTimesheetById($timesheetId);
    public function getTimesheetProjectId($timesheetId);
    public function getTimesheetsUnderProjectId($projectId);
    public function getTimesheetsUnderProjectName($projectName);
    public function getAllTimesheets();
    public function getTimesheetsInMonth($month);
    public function getTimesheetsInYear($year);
    public function getTimesheetsInMonthWeek($month, $week);
    public function getRecentlyMarkedTimesheets($offset);
    public function getTimesheetsWithStatus($timesheetStatus, $limit, $offset);
    
    // user specific function
    public function getUserTimesheetsUnderProjectId($projectId, $userId);
    public function getUserTimesheetsUnderProjectName($projectName, $userId);
    public function getUserAllTimesheets($userId);
    public function getUserTimesheetsInMonth($month, $userId);
    public function getUserTimesheetsInYear($year, $userId);
    public function getUserTimesheetsInMonthWeek($month, $week, $userId);
    public function getUserRecentlyMarkedTimesheets($offset, $userId);
    public function getUserTimesheetsWithStatus($timesheetStatus, $limit, $offset, $userId);
    public function findThisWeekTimesheet($userId, $projectId);
    
    // project manager functions
    
    public function markTimesheet($status, $timesheetId, $timesheetMarkTime);
    
}