<?php

namespace Timesheet\User;

class User {
    private $userId;
    private $userName;
    private $userLocation;
    private $userProjects;
    private $userTimeSheets;
    private $userMail;
    private $userAuthentication;
    
	public static function make($data) {
		$user = new self();
		$user->setUserId($data['user_id']);
		$user->setUserName($data['user_name']);
		$user->setUserLocation($data['user_location']);
		$user->setUserMail($data['user_email']);
		return $user;
	}
	
    public function setUserId($userId) { $this->userId = $userId; }
    public function getUserId() { return $this->userId; }
    public function setUserName($userName) { $this->userName = $userName; }
    public function getUserName() { return $this->userName; }
    public function setUserLocation($userLocation) { $this->userLocation = $userLocation; }
    public function getUserLocation() { return $this->userLocation; }
    public function setUserProjects($userProjects) { $this->userProjects = $userProjects; }
    public function getUserProjects() { return $this->userProjects; }
    public function setUserTimesheets($userTimesheets) { $this->userTimesheets = $userTimesheets; }
    public function getUserTimesheets() { return $this->userTimesheets; }
    public function setUserMail($userMail) { $this->userMail = $userMail; }
    public function getUserMail() { return $this->userMail; }
    public function setUserAuthentication($userAuthentication) { $this->userAuthentication = $userAuthentication; }
    public function getUserAuthentication() { return $this->userAuthentication; }
    
    // validation
    
    public static function validateEmail($email) {
        if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    
}