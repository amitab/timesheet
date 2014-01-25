<?php
namespace Timesheet\Task;

class Task {
    
    private $taskId;
    private $taskName;
    private $taskNotes;
    private $taskStartTime;
    private $taskEndTime;
    private $taskWorkTime;
    private $taskTimesheetId;
    private $taskLocation;
    
    public static function make($data) {
        $task = new self();
        
        $task->setTaskId($data['task_id']);
        $task->setTaskName($data['task_name']);
        $task->setTaskNotes($data['task_notes']);
        $task->setTaskStartTime($data['task_start_time']);
        $task->setTaskEndTime($data['task_end_time']);
        $task->setTaskWorkTime($data['task_work_time']);
        $task->setTaskTimesheetId($data['task_timesheet_id']);
        $task->setTaskLocation($data['task_location']);
        
        return $task;
    }
    
    public function getTaskLocation(){
		return $this->taskLocation;
	}

	public function setTaskLocation($taskLocation){
		$this->taskLocation = $taskLocation;
	}
    
    public function getTaskId(){
		return $this->taskId;
	}

	public function setTaskId($taskId){
		$this->taskId = $taskId;
	}
	
	public function getTaskWorkTime(){
		return $this->taskWorkTime;
	}

	public function setTaskWorkTime($taskWorkTime){
		$this->taskWorkTime = $taskWorkTime;
	}

	public function getTaskName(){
		return $this->taskName;
	}

	public function setTaskName($taskName){
		$this->taskName = $taskName;
	}

	public function getTaskNotes(){
		return $this->taskNotes;
	}

	public function setTaskNotes($taskNotes){
		$this->taskNotes = $taskNotes;
	}

	public function getTaskTimesheetId(){
		return $this->taskTimesheetId;
	}

	public function setTaskTimesheetId($taskTimesheetId){
		$this->taskTimesheetId = $taskTimesheetId;
	}

	public function getTaskStartTime(){
		return $this->taskStartTime;
	}

	public function setTaskStartTime($taskStartTime){
		
		$time = new \DateTime();
        $time = $time->format($taskStartTime);
		
		$this->taskStartTime = $time;
	}

	public function getTaskEndTime(){
		return $this->taskEndTime;
	}

	public function setTaskEndTime($taskEndTime){
		
		$time = new \DateTime();
        $time = $time->format($taskEndTime);
		
		$this->taskEndTime = $time;
	}

}