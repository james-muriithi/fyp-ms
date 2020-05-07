<?php


class NotificationGroup
{
    protected $notifications;

    protected $realCount;

    public function __construct(array $notifications, int $count)
    {
        $this->notifications = $notifications;
        $this->realCount = $count;
    }

    public function message()
    {
        return $this->notifications[0]->messageForNotifications($this->notifications, $this->realCount);
    }

    // forward all other calls to the first notification
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->notifications[0], $method], $arguments);
    }
}