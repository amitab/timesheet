<?php
namespace Timesheet\Group;

interface DAO {
    // write only functions
    public function createGroup($groupDetails);
    public function editGroup($groupId);
    public function deleteGroup($groupId);
    
    //read functions
    public function getUsersGroup($userId);
	
}