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
    
    public function createNotification($notificationDetails, $call = false) {
        
        try {
            $valArr = array(
                ':notificationBody' => $notificationDetails->getNotificationBody(),
                ':notificationPriority' => $notificationDetails->getNotificationPriority(),
                ':notificationRead'  => 0,
                ':notificationType' => $notificationDetails->getNotificationType(),
                ':notificationSubjectId' => $notificationDetails->getNotificationSubjectId(),
                ':notificationDate' => $notificationDetails->getNotificationDate()
            );
        
            if(!$call) {
                $this->db->beginTransaction();
            }
            
            $notificationId = $this->_executeQuery('create new notification', $valArr, \Native5\Core\Database\DB::INSERT);
            
            // SQL FOR INSERTING INTO USER_NOTIFICATION TABLE (1:N RELATIONSHIP)
            $sql = 'INSERT INTO `user_notification` (notification_id, to_user_id, from_user_id) VALUES ';
            $valuesArray = array();
            foreach($notificationDetails->getNotificationToUser() as $toUserId) {
                $valuesArray[] = '(' . $notificationId . ', ' . $toUserId . ', ' . $notificationDetails->getNotificationFromUser() . ')';
            }
            $sql .= implode(', ', $valuesArray);
            $sql .= ';';
            
            parent::tableHasPrimaryKey(false);
            $this->_executeQueryString($sql, null, \Native5\Core\Database\DB::INSERT);
            
            if(!$call) {
                $this->db->commitTransaction();
            }
        
        } catch (\Exception $e) {
            $GLOBALS['logger']->info('ERROR AT NOTIFICATION : ' . $e->getMessage());
            if(!$call) {
                $this->db->rollbackTransaction();
                return false;
            } else {
                throw new \Exception($e->getMessage());
            }
            
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
    
    public function markRead($notificationId) {
        $valArr = array(
            ':notificationId' => $notificationId
        );
        try {
            return $this->_executeObjectQuery('mark notification', $valArr, \Native5\Core\Database\DB::UPDATE);
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
    
    public function getNotificationsToUser($userId, $offset=null) {
        if($offset != null) {
            $sql = 'SELECT DISTINCT `notification`.* , concat(`user`.`user_first_name`, \' \', `user`.`user_last_name`) AS `from_user` FROM `notification` NATURAL JOIN `user_notification` INNER JOIN `user` ON `user_notification`.`from_user_id` = `user`.`user_id` WHERE `user_notification`.`to_user_id` = ' . $userId . ' ORDER BY `notification`.`notification_date` DESC LIMIT 10 OFFSET ' . (int)$offset . ';';
            $data = $this->_executeObjectQueryString($sql, null, \Native5\Core\Database\DB::SELECT);
            return $data;
        } else {
            $valArr = array(
                ':userId' => $userId
            );
            return $this->_executeObjectQuery('find notifications to user', $valArr, \Native5\Core\Database\DB::SELECT);
        }
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
        $data = $this->_executeQuery('find notification count for user', $valArr, \Native5\Core\Database\DB::SELECT);
        return $data[0]['count'];
    }
}