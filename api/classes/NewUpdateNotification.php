<?php
require_once 'UploadCategory.php';
require_once 'Upload.php';

class NewUpdateNotification extends Notification
{
    private $statuses = [ 'approved','ongoing', 'rejected'];
    protected $uploadCategory;
    protected $upload;
    public function __construct($conn, User $user)
    {
        parent::__construct($conn, $user);
        $this->uploadCategory = new UploadCategory($conn);
        $this->upload = new Upload($conn);
    }

    public function messageForNotification($notification)
    {
        $up = $this->upload->viewUpload($notification['reference_id']);
        $name = $this->uploadCategory->viewCategory($up['category_id'])['name'];
        $level = (int)$notification['level'];

        return ['topic'=> 'Upload Status', 'level'=> $level,
            'message'=>'Your '.$name.' was changed status to '.$this->statuses[$level-1],
            'created_at' => $this->time_elapsed_string($notification['created_at']) ];
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
        $up = $this->upload->viewUpload($first['reference_id']);
        $fname = $this->uploadCategory->viewCategory($up['category_id'])['name'];

        $up1 = $this->upload->viewUpload($second['reference_id']);
        $sname = $this->uploadCategory->viewCategory($up['category_id'])['name'];
        $names =  $fname  . ' and ' . $sname ; // John and Jane
        return ['topic'=> 'Upload Status', 'level'=> $first['level'],
            'message'=> 'Your '.$names.' status was changed to '.$this->statuses[(int)$first['level'] - 1],
            'created_at' => $this->time_elapsed_string($first['created_at'])];
    }

    protected function messageForManyNotifications(array $notifications)
    {
        $last = array_pop($notifications);
        $names = '';

        foreach($notifications as $notification) {
            $up = $this->upload->viewUpload($notification['reference_id']);
            $name = $this->uploadCategory->viewCategory($up['category_id'])['name'];
            $names .= $name  . ', ';
        }
        $up = $this->upload->viewUpload($last['reference_id']);
        $lname = $this->uploadCategory->viewCategory($up['category_id'])['name'];

        $names = substr($names, 0, -2) . ' and ' . $lname ; // Jane, Johnny, James and Jenny
        return ['topic'=> 'Upload Status', 'level'=> 2,
            'message'=> ' Your '.$names.'  status was changed to '.$this->statuses[$last['level'] - 1],
            'created_at' => $this->time_elapsed_string($last['created_at'])];

    }


    protected function messageForManyManyNotifications(array $notifications, int $realCount)
    {
        list($first, $second) = array_slice($notifications, 0, 2);

        $up = $this->upload->viewUpload($first['reference_id']);
        $fname = $this->uploadCategory->viewCategory($up['category_id'])['name'];

        $up1 = $this->upload->viewUpload($second['reference_id']);
        $sname = $this->uploadCategory->viewCategory($up['category_id'])['name'];

        $names = $fname . ', ' . $sname  . ' and ' .  $realCount . ' others'; // Jonny, James and 12 other
        return ['topic'=> 'New Uploads', 'level'=> 2,
            'message'=>$names . ' made a new upload',
            'created_at' => $this->time_elapsed_string($first['created_at'])];
    }
}