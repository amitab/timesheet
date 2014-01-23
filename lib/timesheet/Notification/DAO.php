<?php
namespace Timesheet\Notification;

interface DAO {
    // write only functions
    public function createNotification($notificationDetails, $fromUserId, $toUserIds);
    public function deleteNotification($notificationId);
    
    //read functions
    public function getNotificationById($notificationId);
    public function getNotificationFromUser($userId);
    public function getNotificationsToUser($userId);
    public function getNotificationsByPriority($priorityLevel);
    public function getUnreadNotificationsForUser($userId);
    public function getUnreadNotificationCountForUser($userId);
	
}