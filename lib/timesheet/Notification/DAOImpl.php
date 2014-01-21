<?php

namespace Timesheet\Notification;

class DAOImpl extends \Native5\Core\Database\DBDAO implements \Timesheet\Notification\DAO {
	const QUERIES_FILE = 'queries.cfg.yml';
	
	public function __construct(\Native5\Core\Database\DB $db = null) {
        // Initialize the database connection
        if (!empty($db))
            parent::__construct($db);
        else
            // Read settings.yml using the application configuration wrapper
            parent::setDBFromConfigurationArray($GLOBALS['app']->getConfiguration()->getRawConfiguration('database'));

        // Load the sql queries file
        parent::loadQueries(__DIR__.DIRECTORY_SEPARATOR.self::QUERIES_FILE);
    }
	
	// Data Transaction Functions
	
    public function createNotification($notificationDetails, $fromUserId, $toUserIds) {
        $valArr = array(
            ':notificationBody' => $notificationDetails->getNotificationBody(),
            ':notificationPriority' => $notificationDetails->getNotificationPriority(),
            ':notificationRead'  => $notificationDetails->getNotificationRead(),
        );
        $userNotificationQuery = 'INSERT INTO `user_notification` (notification_id, to_user_id, from_user_id) ';
        
        foreach($toUserIds as $toUserId) {
            $userNotificationQuery .= '';
        }
        
        return $this->_executeObjectQuery('create new notification', $valArr, \Native5\Core\Database\DB::INSERT);
        
    }
    
    public function deleteNotification($notificationId) {
        $valArr = array(
            ':notificationId' => $notificationId
        );
        return $this->_executeObjectQuery('delete notification by id', $valArr, \Native5\Core\Database\DB::DELETE);
    }
	
	
	
	public function getNotificationById($notificationId) {
        $valArr = array(
            ':notificationId' => $notificationId
        );
        return $this->_executeObjectQuery('find notification by id', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getNotificationFromUser($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find notifications from user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getNotificationsToUser($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find notifications to user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getNotificationsByPriority($priorityLevel) {
        $valArr = array(
            ':priority' => $priorityLevel
        );
        return $this->_executeObjectQuery('find notifications by priority', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getUnreadNotificationsForUser($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find notifications for user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
    
    public function getUnreadNotificationCountForUser($userId) {
        $valArr = array(
            ':userId' => $userId
        );
        return $this->_executeObjectQuery('find notification count for user', $valArr, \Native5\Core\Database\DB::SELECT);
    }
	
	// Executors
	
	private function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0]))
            return false;

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = \Timesheet\Group\Group::make($res); 
        } else {
            return true;
        }

        return $results;
	}
}