<?php
namespace Timesheet\Project;

interface DAO {
    // write only functions
    public function createProject($projectDetails);
    public function editProject($projectId);
    public function deleteProject($projectId);

    // read only functions
    public function getAllProjects();
    public function getProjectWithId($id);
    public function getProjectsInWeek($week);
    public function findProjectByName($projectName);
}