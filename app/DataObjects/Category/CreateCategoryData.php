<?php

declare(strict_types=1);

namespace App\DataObjects\Category;

use App\Entity\User;

class CreateCategoryData
{
    public function __construct(
        public string $name,
        public User   $user
    )
    {
    }
}