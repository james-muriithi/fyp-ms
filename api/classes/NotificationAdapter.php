<?php


class NotificationAdapter extends Notification
{
    /**
     * @var PDO
     */
    protected $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function add(Notification $notification): bool
    {
        return true;
    }

    public function isDuplicate(Notification $notification):bool
    {
        $query = 'SELECT id FROM notifications WHERE recipient_id =:recipient_id AND type=:type AND reference_id=:reference_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recipient_id', $notification->recipient);
        $stmt->bindParam(':type', $notification->type);
        $stmt->bindParam(':reference_id', $notification->referenceId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function getNotifications(User $user, $limit = 20):array
    {
        $query = 'select *, count(*) as count from notifications
                    WHERE recipient_id =:recipient_id AND unread = 1
                    group by `type`, `recipient_id`, `level`
                    order by created_at desc, unread desc
                    limit 20';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recipient_id', $user->username);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $notificationGroups = [];

        foreach($results as $notification) {
            $notificationGroup = ['count' => $notification['count']];

            // when the group only contains one item we don't
            // have to select it's children
            if ($notification['count'] == 1) {
                $notificationGroup['notifications'] = [$notification];
            } else {
                // example with query builder
                $notificationGroup['notifications'] = $this->getAll($user->username, $notification['type']);
            }

            $notificationGroups[] = $notificationGroup;
        }
        return $notificationGroups;
    }

    public function getAll($recipient_id, $type)
    {
        $query = 'select * from notifications
                    WHERE recipient_id =:recipient_id AND type = :type AND unread = 1
                    order by created_at desc, unread desc
                    limit 5';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':recipient_id', $recipient_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead($recipient, $reference_id, $type):bool
    {
        $query = 'UPDATE notifications SET unread=0 WHERE recipient_id = :recipient AND type = :type AND reference_id = :reference';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':recipient', $recipient);
        $stmt->bindParam(':reference', $reference_id);

        return $stmt->execute();
    }

    public function markAsReadWithId($id):bool
    {
        $query = 'UPDATE notifications SET unread=0 WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function markAllAsRead($recipient):bool
    {
        $query = 'UPDATE notifications SET unread=0 WHERE recipient_id = :recipient';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recipient', $recipient);

        return $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function messageForNotification(Notification $notification): string
    {
        // TODO: Implement messageForNotification() method.
    }

    public function messageForNotifications(array $notifications): string
    {
        // TODO: Implement messageForNotifications() method.
    }
}