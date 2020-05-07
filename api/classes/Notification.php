<?php
class Notification extends NotificationManager
{
    /**
     * @var PDO
     * @var User
     */
    protected $conn;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    protected $user;
    public function __construct($conn, User $user)
    {
        $this->conn = $conn;
        $this->user = $user;
        parent::__construct($conn);
    }


}
