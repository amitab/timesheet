<?php

namespace Timesheet\Project;

class Project {
    private $projectId;
    private $projectName;
    private $projectStatus;
    private $projectTimeAlloted;
    private $projectDescription;
    private $projectCreatedDate;
    private $projectTimesheets;
    private $projectManagerId;
    private $projectSalary;
    private $readableProjectStatus;
    
    const HIGH_PRIORITY = 0;
    const MEDIUM_PRIORITY = 1;
    const LOW_PRIORITY = 2;
    
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
        
        return $project;
    }
    
    public function setProjectId($projectId) { $this->projectId = $projectId; }
    public function getProjectId() { return $this->projectId; }
    public function setProjectName($projectName) { $this->projectName = $projectName; }
    public function getProjectName() { return $this->projectName; }
    public function setProjectStatus($projectStatus) { 
        $this->projectStatus = $projectStatus; 
        if($projectStatus == HIGH_PRIORITY) {
            $readableProjectStatus = 'High Priority';
        } else if($projectStatus == MEDIUM_PRIORITY) {
            $readableProjectStatus = 'Medium Priority';
        } else if($projectStatus == LOW_PRIORITY) {
            $readableProjectStatus = 'Low Priority';
        }
    }
    public function getProjectStatus() { return $this->projectStatus; }
    public function setProjectTimeAlloted($projectTimeAlloted) { $this->projectTimeAlloted = $projectTimeAlloted; }
    
    public function getProjectSalary() { return $this->projectSalary; }
    public function setProjectSalary($projectSalary) { $this->projectSalary = $projectSalary; }
    
    public function getProjectTimeAlloted() { return $this->projectTimeAlloted; }
    public function setProjectDescription($projectDescription) { $this->projectDescription = $projectDescription; }
    public function getProjectDescription() { return $this->projectDescription; }
    public function setProjectCreatedDate($projectCreatedDate) { $this->projectCreatedDate = $projectCreatedDate; }
    public function getProjectCreatedDate() { return $this->projectCreatedDate; }
    public function setProjectTimesheets($projectTimesheets) { $this->projectTimesheets = $projectTimesheets; }
    public function getProjectTimesheets() { return $this->projectTimesheets; }
    public function setProjectManagerId($projectManagerId) { $this->projectManagerId = $projectManagerId; }
    public function getProjectManagerId() { return $this->projectManagerId; }

} 