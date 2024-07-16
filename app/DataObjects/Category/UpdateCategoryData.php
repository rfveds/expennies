<?php

declare(strict_types=1);

namespace App\DataObjects\Category;

class UpdateCategoryData
{
    public function __construct(
        public string $name
    )
    {
    }
}