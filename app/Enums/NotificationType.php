<?php

namespace App\Enums;

enum NotificationType: string
{

    use Identity;

    case ORDER = 'order';
    case SERVICE = 'service';
    case CHAT = 'chat';
    case ACCOUNT = 'account';
}
