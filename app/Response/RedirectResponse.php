<?php

declare(strict_types=1);

namespace App\Response;

use App\Utils\NotificationManager;

class RedirectResponse implements Response
{

    private string $location;
    private ?array $notification = null;

    public function __construct(string $location, ?array $notification = null)
    {
        $this->location = $location;
        $this->notification = $notification;
    }

    public function send()
    {
        if ($this->notification) {
            NotificationManager::setNotification($this->notification['message'], $this->notification['type']);
        }

        session_write_close();
        header('Location: ' . $this->location);
        exit;
    }
}