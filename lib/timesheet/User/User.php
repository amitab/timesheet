<?php

namespace Timesheet\User;

class User {
    private $userId;
    private $userLocation;
    private $userMail;
    private $userPhoneNumber;
    private $userImageUrl;
    private $userSex;
    private $userFirstName;
    private $userLastName;
    
    private $subject;
    
	public static function make($data) {
		$user = new self();
		$user->setUserId($data['user_id']);
		$user->setUserLocation($data['user_location']);
		$user->setUserMail($data['user_email']);
		$user->setUserPhoneNumber($data['user_phone_number']);
		$user->setUserImageUrl($data['user_image_url']);
		$user->setUserSex($data['user_sex']);
		$user->setUserFirstName($data['user_first_name']);
		$user->setUserLastName($data['user_last_name']);
		return $user;
	}
	
    public function setUserId($userId) { $this->userId = $userId; }
    public function getUserId() { return $this->userId; }
    public function setUserName($userName) { $this->userName = $userName; }
    public function getUserName() { return $this->userName; }
    
    public function setUserFirstName($userFirstName) { $this->userFirstName = $userFirstName; }
    public function getUserFirstName() { return $this->userFirstName; }
    public function setUserLastName($userLastName) { $this->userLastName = $userLastName; }
    public function getUserLastName() { return $this->userLastName; }
    
    public function setUserLocation($userLocation) { $this->userLocation = $userLocation; }
    public function getUserLocation() { return $this->userLocation; }
    public function setUserMail($userMail) { $this->userMail = $userMail; }
    public function getUserMail() { return $this->userMail; }
    
    public function setUserPhoneNumber($userPhoneNumber) { $this->userPhoneNumber = $userPhoneNumber; }
    public function getUserPhoneNumber() { return $this->userPhoneNumber; }
    public function setUserImageUrl($userImageUrl) { $this->userImageUrl = $userImageUrl; }
    public function getUserImageUrl() { return $this->userImageUrl; }
    public function setUserSex($userSex) { $this->userSex = $userSex; }
    public function getUserSex() { return $this->userSex; }
    
    public function getSubject() { return $this->subject; }
    public function setSubject($subject) { $this->subject = $subject; }
    
    // validation
    
    public static function validateEmail($email) {
        if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    
}