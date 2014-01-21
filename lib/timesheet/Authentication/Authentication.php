<?php

namespace Timesheet\Authentication;

class Authentication {
    private $groupId;
	private $userId;
	private $password;
	
	public static function make($data) {
	    $authentication = new self();
	    
	    $authentication->setGroupId($data['group_id']);
	    $authentication->setUserId($data['user_id']);
	    $authentication->setPassword($data['password']);
	    
	    return $authentication;
	}
	
	public function getGroupId () { return $this->groupId; }
	public function getUserId () { return $this->userId; }
	public function getPassword () { return $this->password; }
	public function setGroupId ($groupId) { $this->groupId = $groupId; }
	public function setUserId ($userId) { $this->userId = $userId; }
	public function setPassword ($password) { $this->password = $password; }
} 