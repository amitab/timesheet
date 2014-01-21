<?php
namespace Timesheet\Project;

interface DAO {
    // write only functions
    public function createProject($projectDetails);
    public function editProject($projectId);
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
        
    // admin functions
        
    public function addUsersToProject($projectId, $userIds);
        
}