<?php

class NewUploadNotification extends Notification
{
    public function __construct($conn, User $user)
    {
        parent::__construct($conn, $user);
    }

    public function messageForNotification($notification)
    {
        if ((int) $this->getUser()->getLevel() === 3){
            return $this->studentMessage($this->time_elapsed_string($notification['created_at']));
        }
        return ['topic'=> 'New Uploads', 'level'=> 2, 'message'=>$notification['sender_id'] . ' made a new upload'];
    }

    public function studentMessage( $date = '')
    {
        return ['topic'=> 'Upload Success', 'level'=> 1, 'message'=>'Your upload(s) were made successfully',
            'created_at' => $date
        ];
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
        elseif ($realCount < 5) {
            $names = $this->messageForManyNotifications($notifications);
        }
        // to many
        else {
            $names = $this->messageForManyManyNotifications($notifications, $realCount);
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
        if ((int) $this->getUser()->getLevel() === 3){
            return $this->studentMessage($this->time_elapsed_string($notifications[0]['created_at']));
        }
        list($first, $second) = $notifications;
        $names =  $first['sender_id']  . ' and ' . $second['sender_id'] ; // John and Jane
        return ['topic'=> 'New Uploads', 'level'=> 2, 'message'=>$names . ' made a new upload', 'created_at' => $this->time_elapsed_string($first['created_at'])];
    }

    protected function messageForManyNotifications(array $notifications)
    {
        if ((int) $this->getUser()->getLevel() === 3){
            return $this->studentMessage($this->time_elapsed_string($notifications[0]['created_at']));
        }

        $last = array_pop($notifications);
        $names = '';
        foreach($notifications as $notification) {
            $names .= $notification['sender_id']  . ', ';
        }

        $names = substr($names, 0, -2) . ' and ' . $last['sender_id'] ; // Jane, Johnny, James and Jenny
        return ['topic'=> 'New Uploads', 'level'=> 2, 'message'=>$names . ' made a new upload', 'created_at' => $this->time_elapsed_string($first['created_at'])];

    }


    protected function messageForManyManyNotifications(array $notifications, int $realCount)
    {
        if ((int) $this->getUser()->getLevel() === 3){
            return $this->studentMessage($this->time_elapsed_string($notifications[0]['created_at']));
        }

        list($first, $second) = array_slice($notifications, 0, 2);

        $names = $first['sender_id'] . ', ' . $second['sender_id']  . ' and ' .  $realCount . ' others'; // Jonny, James and 12 other
        return ['topic'=> 'New Uploads', 'level'=> 2, 'message'=>$names . ' made a new upload', 'created_at' => $this->time_elapsed_string($first['created_at'])];
    }
}