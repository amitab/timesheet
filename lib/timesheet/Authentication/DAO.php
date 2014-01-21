<?php
namespace Timesheet\Group;

interface DAO {
    // write only functions
    public function createAuthentication($authenticationDetails);
    public function editAuthentication($userId);
    
    //read functions
    public function getUsersAuthentication($userId);
	
}