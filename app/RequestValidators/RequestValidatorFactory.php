<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\RequestValidatorInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

readonly class RequestValidatorFactory implements RequestValidatorFactoryInterface
{
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function make(string $class): RequestValidatorInterface
    {
        $validator = $this->container->get($class);

        if (!$validator instanceof RequestValidatorInterface) {
            throw new \RuntimeException('Failed to create request validator.' . $class . ' is not an instance of RequestValidatorInterface.');
        }

        return $validator;
    }
}