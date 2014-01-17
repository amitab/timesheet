<?php

namespace Timesheet\Project;

class ProjectModel {
    private $projectId;
    private $projectName;
    private $projectStatus;
    private $projectTimeAlloted;
    private $projectDescription;
    private $projectCreatedDate;
    private $projectTimesheets;
    private $projectEmployer;
    
    public function setProjectId($projectId) { $this->projectId = $projectId; }
    public function getProjectId() { return $this->projectId; }
    public function setProjectName($projectName) { $this->projectName = $projectName; }
    public function getProjectName() { return $this->projectName; }
    public function setProjectStatus($projectStatus) { $this->projectStatus = $projectStatus; }
    public function getProjectStatus() { return $this->projectStatus; }
    public function setProjectTimeAlloted($projectTimeAlloted) { $this->projectTimeAlloted = $projectTimeAlloted; }
    public function getProjectTimeAlloted() { return $this->projectTimeAlloted; }
    public function setProjectDescription($projectDescription) { $this->projectDescription = $projectDescription; }
    public function getProjectDescription() { return $this->projectDescription; }
    public function setProjectCreatedDate($projectCreatedDate) { $this->projectCreatedDate = $projectCreatedDate; }
    public function getProjectCreatedDate() { return $this->projectCreatedDate; }
    public function setProjectTimesheets($projectTimesheets) { $this->projectTimesheets = $projectTimesheets; }
    public function getProjectTimesheets() { return $this->projectTimesheets; }
    public function setProjectEmployer($projectEmployer) { $this->projectEmployer = $projectEmployer; }
    public function getProjectEmployer() { return $this->projectEmployer; }

} 