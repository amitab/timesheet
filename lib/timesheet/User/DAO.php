<?php

namespace Timesheet\User;

interface DAO {
    // write only functions
    public function createUser($userDetails);
    public function editUser($userDetails);
    public function deleteUser($userId);

    // read only functions
    public function getAllUsers();
    public function getUserById($userId);
    public function getUsersUnderProjectId($projectId);
    public function getUsersUnderProjectName($projectName);
    public function getUserByName($userName);
	public function getUserProjectCount($userId);
	public function getUserTimesheetCount($userId);
	public function getUserHourCount($userId);

    //public function getAllUsersUnderGroup($groupId);
}