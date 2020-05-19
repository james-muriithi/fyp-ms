<?php


class NewMessageNotification extends Notification
{
    public function __construct($conn, User $user)
    {
        parent::__construct($conn, $user);
    }

    public function messageForNotification($notification)
    {
        return ['topic'=> 'New Message', 'level'=> 2, 'message'=>' You have a new message', 'created_at' => $this->time_elapsed_string($notification['created_at'])];
    }

    public function messageForNotifications(array $notifications, int $realCount = 0)
    {
        $realCount = $realCount === 0 ? count($notifications) : $realCount;

        if ($realCount === 0) {
            return null;
        }

        if ($realCount === 1) {
            $names = $this->messageForNotification($notifications[0]);
        }

        // when there are two
        elseif ($realCount === 2) {
            $names = $this->messageForTwoNotifications($notifications);
        }
        // less than five
        else{
            $names = $this->messageForManyNotifications($notifications);
        }

        return $names;
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    protected function messageForTwoNotifications(array $notifications)
    {
        list($first, $second) = $notifications;
//        $names =  $first['sender_id']  . ' and ' . $second['sender_id'] ; // John and Jane
        return ['topic'=> 'New Messages', 'level'=> 2,'message'=>'You have 2 new messages', 'created_at' => $this->time_elapsed_string($first['created_at'])];
    }



    protected function messageForManyNotifications(array $notifications)
    {
        list($first, $second) = array_slice($notifications, 0, 2);
        return ['topic'=> 'New Uploads', 'level'=> 2, 'message'=> 'You have '.count($notifications) . ' new messages', 'created_at' => $this->time_elapsed_string($first['created_at'])];
    }
}