<?php


class ProjectUpdateNotification extends Notification
{
    private $statuses = [ '<b class="text-bold">approved</b>','<b class="text-bold">ongoing</b>',
        '<b class="text-bold">rejected</b>'];

    public function __construct($conn, User $user)
    {
        parent::__construct($conn, $user);
    }

    public function messageForNotification($notification)
    {
        return ['topic' => 'Project Status', 'level' => $notification['level'],
            'message' => 'Your Project was changed status to ' . $this->statuses[(int)$notification['level'] - 1],
            'created_at' => $this->time_elapsed_string($notification['created_at'])];
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

        return $names;
    }

    public function time_elapsed_string($datetime, $full = false)
    {
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
}