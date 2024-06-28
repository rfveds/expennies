<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Ramsey\Uuid\UuidInterface;

readonly class UserProviderService implements UserProviderServiceInterface
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function getById(UuidInterface $userId): ?UserInterface
    {
        return $this->entityManager->find(User::class, $userId);
    }

    public function getByCredentials(array $credentials): ?UserInterface
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);
    }
}