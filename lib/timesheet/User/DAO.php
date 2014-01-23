<?php

namespace Timesheet\User;

interface DAO {
    // write only functions
    public function createUser($userDetails);
    public function editUser($userDetails);
    public function deleteUser($userId);
    public function editUserPassword($userId, $password);
    /*public function uploadUserImage($imageUrl);
    public function removeUserImage($imageUrl);*/

    // read only functions
    public function getAllUsers();
    public function getUserById($userId);
    public function getUsersUnderProjectId($projectId);
    public function getUsersUnderProjectName($projectName);
    public function getUserByName($userName);
    public function getUserByNameExcept($userName, $userIds);
	public function getUserProjectCount($userId);
	public function getUserTimesheetCount($userId);
	public function getUserHourCount($userId);

    public function getUsersUnderGroup($group);
    public function getUserByPhoneNumber($userPhoneNumber);
    public function getUserImageUrl($userId);
}