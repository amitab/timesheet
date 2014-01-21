<?php

namespace Timesheet\Notification;

class Notification {
    private $notificationId;
    private $notificationBody;
    private $notificationFromUser;
    private $notificationToUser;
    private $notificationPriority;
    private $notificationRead;
    
    public static function make($data) {
        $notification = new self();
        
        $notification->setNotificationId($data['notification_id']);
        $notification->setNotificationBody($data['notification_body']);
        $notification->setNotificationFromUser($data['notification_from_user']);
        $notification->setNotificationToUser($data['notification_to_user']);
        $notification->setNotificationPriority($data['notification_priority']);
        $notification->setNotificationRead($data['notification_read']);
        
        return $notification;
    }
    
    public function getNotificationId(){
		return $this->notificationId;
	}

	public function setNotificationId($notificationId){
		$this->notificationId = $notificationId;
	}

	public function getNotificationBody(){
		return $this->notificationBody;
	}

	public function setNotificationBody($notificationBody){
		$this->notificationBody = $notificationBody;
	}

	public function getNotificationFromUser(){
		return $this->notificationFromUser;
	}

	public function setNotificationFromUser($notificationFromUser){
		$this->notificationFromUser = $notificationFromUser;
	}

	public function getNotificationToUser(){
		return $this->notificationToUser;
	}

	public function setNotificationToUser($notificationToUser){
		$this->notificationToUser = $notificationToUser;
	}

	public function getNotificationPriority(){
		return $this->notificationPriority;
	}

	public function setNotificationPriority($notificationPriority){
		$this->notificationPriority = $notificationPriority;
	}

	public function getNotificationRead(){
		return $this->notificationRead;
	}

	public function setNotificationRead($notificationRead){
		$this->notificationRead = $notificationRead;
	}
    
} 