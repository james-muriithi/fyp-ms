<?php
class Notification extends NotificationManager
{
    /**
     * @var PDO
     */
    protected $conn;
    /**
     *  @var User
     * */
    protected $user;

    protected $sender;
    protected $recipient;
    protected $type;
    protected $referenceId;

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient($recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @param mixed $referenceId
     */
    public function setReferenceId($referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function __construct($conn, User $user)
    {
        $this->conn = $conn;
        $this->user = $user;
        parent::__construct($conn);
    }


}
