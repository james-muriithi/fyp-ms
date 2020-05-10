<?php
require_once 'UploadCategory.php';

class NewCategoryNotification extends Notification
{
    /**
     * @var UploadCategory
    */
    protected $uploadCategory;
    public function __construct($conn, User $user)
    {
        parent::__construct($conn, $user);
        $this->uploadCategory = new UploadCategory($conn);
    }

    public function messageForNotification($notification)
    {
        $n = $this->uploadCategory->viewCategory($notification['reference_id'])['name'];
        return ['topic'=> 'New Category', 'level'=> 2, 'message'=>'A new upload Category <strong class="text-bold">'.$n.'</strong> has been added',
            'created_at' => $this->time_elapsed_string($notification['created_at'])
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
        list($first, $second) = $notifications;
        $names =  $this->uploadCategory->viewCategory($first['reference_id'])['name']  . ' and ' . $this->uploadCategory->viewCategory($second['reference_id'])['name'] ; // John and Jane
        return ['topic'=> 'New Categories', 'level'=> 2, 'message'=>$names . ' were added.', 'created_at' => $this->time_elapsed_string($first['created_at'])];
    }

    protected function messageForManyNotifications(array $notifications)
    {

        $last = array_pop($notifications);
        $names = '';
        foreach($notifications as $notification) {
            $names .= $this->uploadCategory->viewCategory($notification['reference_id'])['name']  . ', ';
        }

        $names = substr($names, 0, -2) . ' and ' . $last['sender_id'] ; // Jane, Johnny, James and Jenny
        return ['topic'=> 'New Categories', 'level'=> 2, 'message'=>$names . ' were added',
            'created_at' => $this->time_elapsed_string($last['created_at'])];

    }


    protected function messageForManyManyNotifications(array $notifications, int $realCount)
    {
        list($first, $second) = array_slice($notifications, 0, 2);

        $names =  $this->uploadCategory->viewCategory($first['reference_id'])['name']  . ' and ' . $this->uploadCategory->viewCategory($second['reference_id'])['name']  . ' and ' .  $realCount . ' others'; // Jonny, James and 12 other
        return ['topic'=> 'New Uploads', 'level'=> 2, 'message'=>$names . ' made a new upload',
            'created_at' => $this->time_elapsed_string($first['created_at'])];
    }
}