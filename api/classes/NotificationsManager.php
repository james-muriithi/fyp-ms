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

    public function markRead(array $notifications){

    }

    public function get(User $user, $limit = 20) : array
    {
        return $this->notificationAdapter->getNotifications($user);
    }
}