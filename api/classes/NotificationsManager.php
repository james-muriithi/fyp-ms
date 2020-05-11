<?php
class NotificationManager
{
    protected $conn;
    /**
     * @var NotificationAdapter
     * */
    protected $notificationAdapter;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->notificationAdapter = new NotificationAdapter($this->conn);
    }

    public function add(Notification $notification):bool
    {
        if(!$this->notificationAdapter->isDuplicate($notification)){
            return $this->notificationAdapter->add($notification);
        }
        return false;
    }


    /**
     * @param $notification Notification
     * @return bool
     */
    public function markRead($notification):bool
    {
        return $this->notificationAdapter->markAsRead($notification->getRecipient(), $notification->getReferenceId(), $notification->getType());
    }

    /**
     * @param $notification Notification
     * @return bool
     */
    public function markAllAsRead($notification):bool
    {
        return $this->notificationAdapter->markAllAsRead($notification->getRecipient());
    }

    public function get(User $user, $limit = 20) : array
    {
        return $this->notificationAdapter->getNotifications($user);
    }
}