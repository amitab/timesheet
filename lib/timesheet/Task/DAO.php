<?php

namespace Timesheet\Task;

interface DAO {
    
    // write only
    
    public function createTask($task, $timesheetId, $call);
    public function deleteTask($taskId);
    public function editTask($task);
    
    public function markTask($taskId, $mark);
    
    // read only
    
    public function getAllTasksOfTimesheet($timesheetId);
    public function getTaskById($taskId);
    public function getTaskByName($taskName);
    public function getTaskUnderProjectByName($taskName, $projectId);
    public function getTaskUnderTimesheetByName($taskName, $timesheetId);
    public function getTotalWorkTimeOfTimesheet($timesheetId);
    public function getTotalPauseTimeOfTimesheet($timesheetId);
}