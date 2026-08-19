<?php

namespace App\Enums;

enum RoleName: string
{
    case USER = 'user';
    case OWNER = 'owner';
    case ADMIN = 'admin';
}