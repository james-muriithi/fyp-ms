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
        $query = 'SELECT id FROM notifications WHERE recipient_id =:recipient_id AND sender_id=:sender_id AND type=:type AND reference_id=:reference_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sender_id', $notification->sender);
        $stmt->bindParam(':recipient_id', $notification->recipient);
        $stmt->bindParam(':type', $notification->type);
        $stmt->bindParam(':reference_id', $notification->referenceId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function getNotifications(User $user, $limit = 20):array
    {
        $query = 'select *, count(*) as count from notifications
                    WHERE recipient_id =:recipient_id
                    group by `type`, `recipient_id`
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
                    WHERE recipient_id =:recipient_id AND type = :type
                    order by created_at desc, unread desc
                    limit 5';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':recipient_id', $recipient_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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