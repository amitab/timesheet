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
    public function getProjectsWithSalaryGreaterThan($projectSalary);
    public function getProjectsWithSalaryLessThan($projectSalary);
    public function getProjectOfTimesheet($timesheetId);
    public function getEmployeeTotalWorkTime($userId, $projectId);
    public function getEmployeeTotalPauseTime($userId, $projectId);
    public function getProjectNameById($projectId);
    public function getProjectManagerId($projectId);
    public function getProjectState($projectId);
        
    // admin functions
        
    public function addUsersToProject($projectId, $userIds, $notification);
    public function getProjectTotalWorkTime($projectId);
        
    public function markCompleted($projectId);
        
        
    public function getProjectsHandledByUserId($userId);
    public function getProjectsCreatedByUserId($userId);
    public function getProjectsIncomplete($userId);
    public function getProjectsComplete($userId);
    public function getProjectsOverdue($userId);
    public function getAllProjectsOfUser($userId);
        
        
    public function searchByNameUnderUserId($projectName, $userId);
    public function searchByNameUnderManagerId($projectName, $userId);
    public function searchByNameUnderIncomplete($projectName, $userId);
    public function searchByNameUnderComplete($projectName, $userId);
    public function searchByNameUnderOverdue($projectName, $userId);
    public function searchAllProjects($projectName, $userId);
        
}