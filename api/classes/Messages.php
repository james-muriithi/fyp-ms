<?php


class Messages extends User
{
    /**
     * @var PDO
     * */
    public $conn;
    public function __construct($conn, $username)
    {
        $this->conn = $conn;
        parent::__construct($conn);
        $this->setUsername($username);
    }

    public function saveMessage($to, $message ):bool
    {
        $query = 'INSERT INTO messages SET sender=:from, receiver=:to, message=:message';

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':from', $username);
        $stmt->bindParam(':to', $to);
        $stmt->bindParam(':message', $message);

        return $stmt->execute();
    }

    public function getAllMessages():mixed
    {
        $query = 'SELECT * FROM messages 
                   WHERE receiver=:receiver';

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':receiver', $username);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//    unread messages
    public function getAllUnreadMessages():array
    {
        $query = 'SELECT * FROM messages 
                   WHERE receiver=:receiver and `read`= 0';

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':receiver', $username);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//    single sender unread messages
    public function getSenderAllUnreadMessages($sender):array
    {
        $query = 'SELECT * FROM messages 
                   WHERE receiver=:receiver and sender= :sender and `read`= 0 ORDER BY created_at ASC';

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':receiver', $username);
        $stmt->bindParam(':sender', $sender);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return  [];
    }

    public function getLastMessage($sender)
    {
        $query = "SELECT message,created_at FROM messages 
                   WHERE receiver=:receiver and sender=:sender or receiver=:sender and sender=:receiver ORDER BY created_at DESC LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':receiver', $username);
        $stmt->bindParam(':sender', $sender);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSenderAllMessages($sender):array
    {
        $query = "SELECT * FROM messages 
                   WHERE receiver=:receiver and sender=:sender or receiver=:sender and sender=:receiver ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':receiver', $username);
        $stmt->bindParam(':sender', $sender);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


//    mark sender messages as read
    public function markSenderMessagesRead($sender):bool
    {
        $query = 'UPDATE messages SET `read` = 1
                   WHERE receiver=:receiver and sender=:sender';

        $stmt = $this->conn->prepare($query);

        $username = $this->getUsername();

        $stmt->bindParam(':receiver', $username);
        $stmt->bindParam(':sender', $sender);

        return $stmt->execute();
    }


}