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
    private $taskStatus;
    
    private $notification;
    public $prettyWorkTime;
    
    private $readableTaskState;
    const STATUS_UNCHECKED = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;
    
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
        $task->setTaskStatus($data['task_status']);
        
        return $task;
    }
    
    public function getTaskLocation(){
		return $this->taskLocation;
	}

	public function setTaskLocation($taskLocation){
		$this->taskLocation = $taskLocation;
	}
    
    public function getTaskStatus(){
		return $this->taskStatus;
	}

	public function setTaskStatus($taskStatus){
		$this->taskStatus = $taskStatus;
		if($taskStatus == self::STATUS_UNCHECKED) {
		    $this->readableTaskState = 'UNCHECKED';
		} else if($taskStatus == self::STATUS_ACCEPTED) {
		    $this->readableTaskState = 'ACCEPTED';
		} else if($taskStatus == self::STATUS_REJECTED) {
		    $this->readableTaskState = 'REJECTED';
		}
	}
    
    public function getReadableTaskState(){
		return $this->readableTaskState;
	}

	public function setReadableTaskState($readableTaskState){
		$this->readableTaskState = $readableTaskState;
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
		$hours = round(($taskWorkTime) / 3600);
		$minutes = round(($taskWorkTime % (3600)) / 60);
		$seconds = round($taskWorkTime % 60);
		
		$this->prettyWorkTime = $hours . ':' . $minutes . ':' . $seconds;
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
	
	public function getNotification(){
		return $this->notification;
	}

	public function setNotification($notification){
		$this->notification = $notification;
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