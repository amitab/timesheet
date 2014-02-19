<?php

namespace Timesheet\Notification;

class Notification {
    private $notificationId;
    private $notificationBody;
    private $notificationFromUser;
    private $notificationPriority;
    private $notificationRead;
    private $notificationType;
    private $notificationSubjectId;
    private $notificationDate;
    private $dataObject;
    
    private $notificationToUser;
    
    private $readableType;
    private $readablePriority;
    private $url;
    
    const TYPE_PROJECT = 0;
    const TYPE_TASK = 1;
    
    const PRIORITY_HIGH = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_LOW = 2;
    
    const READ = 1;
    const UNREAD = 0;
    
    public static function make($data) {
        $notification = new self();
        
        $notification->setNotificationId($data['notification_id']);
        $notification->setNotificationBody($data['notification_body']);
        $notification->setNotificationPriority($data['notification_priority']);
        $notification->setNotificationRead($data['notification_read']);
        $notification->setNotificationType($data['notification_type']);
        $notification->setNotificationSubjectId($data['notification_subject_id']);
        $notification->setNotificationFromUser($data['from_user']);
        $notification->setNotificationDate($data['notification_date']);
                
        return $notification;
    }
    
    public function getNotificationId(){
		return $this->notificationId;
	}

	public function setNotificationId($notificationId){
		$this->notificationId = $notificationId;
	}
	
	public function getNotificationDate(){
		return $this->notificationDate;
	}

	public function setNotificationDate($notificationDate){
		$this->notificationDate = $notificationDate;
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
		if($notificationPriority == self::PRIORITY_HIGH) {
		    $this->readablePriority = 'High';
		} else if($notificationPriority == self::PRIORITY_MEDIUM) {
		    $this->readablePriority = 'Medium';
		} else if($notificationPriority == self::PRIORITY_LOW) {
		    $this->readablePriority = 'Low';
		} 
	}

	public function getNotificationRead(){
		return $this->notificationRead;
	}

	public function setNotificationRead($notificationRead){
		$this->notificationRead = $notificationRead;
	}
    
    public function getNotificationType(){
		return $this->notificationType;
	}

	public function setNotificationType($notificationType){
		$this->notificationType = $notificationType;
		if($notificationType == self::TYPE_PROJECT) {
		    $this->url = "projectdetails.html?id=";
		} else if ($notificationType == self::TYPE_TASK) {
		    $this->url = "taskdetails.html?id=";
		} 
	}

	public function getNotificationSubjectId(){
		return $this->notificationSubjectId;
	}

	public function setNotificationSubjectId($notificationSubjectId){
		$this->notificationSubjectId = $notificationSubjectId;
	}
    
} 