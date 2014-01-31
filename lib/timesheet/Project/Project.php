<?php

namespace Timesheet\Project;

class Project {
    private $projectId;
    private $projectName;
    private $projectStatus;
    private $projectTimeAlloted;
    private $projectDescription;
    private $projectCreatedDate;
    private $projectManagerId;
    private $projectSalary;
    private $projectState;
    
    private $prettyCreatedDate;
    private $prettyDeadline;
    
    private $readableProjectStatus;
    private $readableProjectState;
    
    private $notification;
    
    const HIGH_PRIORITY = 0;
    const MEDIUM_PRIORITY = 1;
    const LOW_PRIORITY = 2;
    
    const STATE_INCOMPLETE = 0;
    const STATE_COMPLETE = 1;
    const STATE_OVERDUE = 2;
    
    public static function make($data) {
        $project = new self();
        
        $project->setProjectId($data['project_id']);
        $project->setProjectName($data['project_name']);
        $project->setProjectStatus($data['project_status']);
        $project->setProjectTimeAlloted($data['project_time_alloted']);
        $project->setProjectDescription($data['project_description']);
        $project->setProjectCreatedDate($data['project_created_date']);
        $project->setProjectManagerId($data['project_manager_id']);
        $project->setProjectSalary($data['project_salary']);
        $project->setProjectState($data['project_state']);
        
        $startTime = strtotime($data['project_created_date']);
        $endTime = strtotime($data['project_time_alloted']);
        $duration = ($endTime - $startTime); 
        
        if($duration < 0) {
            $project->setProjectState(self::STATE_OVERDUE);
        } 
        
        return $project;
    }
    
    public function setProjectId($projectId) { $this->projectId = $projectId; }
    public function getProjectId() { return $this->projectId; }
    public function setProjectState($projectState) {
        $this->projectState = $projectState;
        if($projectState == self::STATE_INCOMPLETE) {
            $this->readableProjectState = 'In Progress';
        } else if($projectState == self::STATE_COMPLETE) {
            $this->readableProjectState = 'Complete';
        } else if($projectState == self::STATE_OVERDUE) {
            $this->readableProjectState = 'Overdue';
        }
    }
    public function getProjectState() { return $this->projectState; }
    public function setProjectName($projectName) { $this->projectName = $projectName; }
    public function getProjectName() { return $this->projectName; }
    public function setProjectStatus($projectStatus) { 
        $this->projectStatus = $projectStatus; 
        if($projectStatus == self::HIGH_PRIORITY) {
            $this->readableProjectStatus = 'High Priority';
        } else if($projectStatus == self::MEDIUM_PRIORITY) {
            $this->readableProjectStatus = 'Medium Priority';
        } else if($projectStatus == self::LOW_PRIORITY) {
            $this->readableProjectStatus = 'Low Priority';
        }
    }
    public function getProjectStatus() { return $this->projectStatus; }
    public function setProjectTimeAlloted($projectTimeAlloted) { 
        $this->projectTimeAlloted = $projectTimeAlloted; 
        $date = new \DateTime($projectTimeAlloted);
        $this->prettyDeadline = $date->format('dS M y');
    }
    
    public function getProjectSalary() { return $this->projectSalary; }
    public function setProjectSalary($projectSalary) { $this->projectSalary = $projectSalary; }
    
    public function getProjectTimeAlloted() { return $this->projectTimeAlloted; }
    public function setProjectDescription($projectDescription) { $this->projectDescription = $projectDescription; }
    public function getProjectDescription() { return $this->projectDescription; }
    public function setProjectCreatedDate($projectCreatedDate) { 
        $this->projectCreatedDate = $projectCreatedDate; 
        $date = new \DateTime($projectCreatedDate);
        $this->prettyCreatedDate = $date->format('dS M y');
    }
    public function getProjectCreatedDate() { return $this->projectCreatedDate; }
    public function setProjectTimesheets($projectTimesheets) { $this->projectTimesheets = $projectTimesheets; }
    public function getProjectTimesheets() { return $this->projectTimesheets; }
    public function setProjectManagerId($projectManagerId) { $this->projectManagerId = $projectManagerId; }
    public function getProjectManagerId() { return $this->projectManagerId; }
    
    public function getReadableProjectState(){
		return $this->readableProjectState;
	}

	public function setReadableProjectState($readableProjectState){
		$this->readableProjectState = $readableProjectState;
	}
	
	
	public function getNotification(){
		return $this->notification;
	}

	public function setNotification($notification){
		$this->notification = $notification;
	}
    
    public function getPrettyCreatedDate(){
		return $this->prettyCreatedDate;
	}

	public function setPrettyCreatedDate($prettyCreatedDate){
		$this->prettyCreatedDate = $prettyCreatedDate;
	}

	public function getPrettyDeadline(){
		return $this->prettyDeadline;
	}

	public function setPrettyDeadline($prettyDeadline){
		$this->prettyDeadline = $prettyDeadline;
	}
    
} 