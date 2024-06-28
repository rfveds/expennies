<?php

namespace App\Enum;

enum SameSite: string
{
    case STRICT = 'strict';
    case LAX = 'lax';
    case NONE = 'none';

}