<?php

namespace App\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';

    public function allowsAuthentication(): bool
    {
        return $this === self::Active;
    }
}
