<?php

namespace Timesheet\Notification;

class DAOImpl extends \Database\DBService implements \Timesheet\Notification\DAO {
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
        parent::setObjectMaker('\Timesheet\Notification\Notification', 'make');
    }
	
	// WRITE FUNCTIONS
	
    public function createNotification($notificationDetails, $fromUserId, $toUserIds) {
        $valArr = array(
            ':notificationBody' => $notificationDetails->getNotificationBody(),
            ':notificationPriority' => $notificationDetails->getNotificationPriority(),
            ':notificationRead'  => 0,
        );
        
        try {
        
            $this->db->beginTransaction();
            
            $notificationId = $this->_executeQuery('create new notification', $valArr, \Native5\Core\Database\DB::INSERT);
            
            // SQL FOR INSERTING INTO USER_NOTIFICATION TABLE (1:N RELATIONSHIP)
            $sql = 'INSERT INTO `user_notification` (notification_id, to_user_id, from_user_id) VALUES ';
            $valuesArray = array();
            foreach($toUserIds as $toUserId) {
                $valuesArray[] = '(' . $notificationId . ', ' . $toUserId . ', ' . $fromUserId . ')';
            }
            $sql .= implode(', ', $valuesArray);
            $sql .= ';';
            
            parent::tableHasPrimaryKey(false);
            $this->_executeQueryString($sql, null, \Native5\Core\Database\DB::INSERT);
            
            $this->db->commitTransaction();
        
        } catch (\Exception $e) {
            $GLOBALS['logger']->info('Exception : ' . $e->getMessage());
            
            $this->db->rollbackTransaction();
            return false;
            
        } 
        
        return true;
        
    }
    
    public function deleteNotification($notificationId) {
        $valArr = array(
            ':notificationId' => $notificationId
        );
        
        try {
            return $this->_executeQuery('delete notification by id', $valArr, \Native5\Core\Database\DB::DELETE);
        } catch (\Exception $e) {
            return false;
        }
    }
	
	// READ FUNCTIONS
	
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
    
    public function getNotificationsByPriority($notificationPriority) {
        $valArr = array(
            ':notificationPriority' => $notificationPriority
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
}