<?php

declare(strict_types=1);

namespace App\Utils;

class NotificationManager
{
    public static function setNotification(string $message, string $type = 'info'): void {
        $_SESSION['notifications'][] = [
            'message' => $message,
            'type' => $type
        ];
    }
}
