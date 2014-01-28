<?php
namespace Timesheet\Project;

interface DAO {
    // write only functions
    public function createProject($projectDetails);
    public function editProject($projectDetails);
    public function deleteProject($projectId);

    // read only functions
    public function getAllProjects();
    public function getProjectById($id);
    public function getProjectsInMonth($month);
    public function getProjectsInYear($year);
    public function findProjectByName($projectName);
    public function getProjectsHandledByUserId($userId);
    public function getProjectsCreatedByUserId($userId);
    public function getProjectsWithSalaryGreaterThan($projectSalary);
    public function getProjectsWithSalaryLessThan($projectSalary);
    public function getProjectOfTimesheet($timesheetId);
    public function searchByNameUnderUserId($projectName, $userId);
    public function getEmployeeTotalWorkTime($userId, $projectId);
    public function getEmployeeTotalPauseTime($userId, $projectId);
    public function getProjectNameById($projectId);
        
    // admin functions
        
    public function addUsersToProject($projectId, $userIds);
    public function getProjectTotalWorkTime($projectId);
        
}