<?php

namespace Timesheet\Notification;

class Service {
	private $_data;
    private $_dao;

    /**
     * 
     * @var Singleton
     */
    private static $instance;

    private function __construct() {
        global $logger;
        $this->_data = array();
        $this->_dao = new \Timesheet\Notification\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// The Cover
	
	// write only functions
    public function createNotification($notificationDetails) {
        return $this->_dao->createNotification($notificationDetails);
    }
    public function deleteNotification($notificationId) {
        return $this->_dao->deleteNotification($notificationId);
    }
    
    public function markRead($notificationId) {
        return $this->_dao->markRead($notificationId);
    }
    
    //read functions
    public function getNotificationById($notificationId) {
        return $this->_dao->getNotificationById($notificationId);
    }
    public function getNotificationFromUser($userId) {
        return $this->_dao->getNotificationFromUser($userId);
    }
    public function getNotificationsToUser($userId, $offset=null) {
        return $this->_dao->getNotificationsToUser($userId, $offset);
    }
    public function getNotificationsByPriority($priorityLevel) {
        return $this->_dao->getNotificationsByPriority($priorityLevel);
    }
    public function getUnreadNotificationsForUser($userId) {
        return $this->_dao->getUnreadNotificationsForUser($userId);
    }
    public function getUnreadNotificationCountForUser($userId) {
        return $this->_dao->getUnreadNotificationCountForUser($userId);
    }
}