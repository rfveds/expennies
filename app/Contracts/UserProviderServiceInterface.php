<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DataObjects\User\RegisterUserData;
use Ramsey\Uuid\UuidInterface;

interface UserProviderServiceInterface
{

    public function getById(UuidInterface $userId): ?UserInterface;

    public function getByCredentials(array $credentials): ?UserInterface;

    public function createUser(RegisterUserData $data): UserInterface;
}