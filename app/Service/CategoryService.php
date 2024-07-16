<?php

declare(strict_types=1);

namespace App\Service;

use App\DataObjects\Category\CreateCategoryData;
use App\DataObjects\Category\UpdateCategoryData;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Ramsey\Uuid\Uuid;

readonly class CategoryService
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    /**
     * @throws ORMException
     */
    public function create(CreateCategoryData $data): Category
    {
        $category = new Category();

        $category->setName($data->name);
        $category->setUser($data->user);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Category::class)->findAll();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(string $categoryId): void
    {
        $category = $this->entityManager->getRepository(Category::class)
            ->find(Uuid::fromString($categoryId));

        if ($category === null) {
            throw new \InvalidArgumentException('Category not found');
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function getById(string $id): ?Category
    {
        return $this->entityManager->find(Category::class, Uuid::fromString($id));
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Category $category, UpdateCategoryData $data): void
    {
        $category->setName($data->name);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
}