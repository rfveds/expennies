<?php

namespace App\Contracts;

use Ramsey\Uuid\UuidInterface;

interface UserInterface
{
    public function getId(): UuidInterface;

    public function getPassword(): string;
}