<?php

declare(strict_types=1);

use Doctrine\DBAL\Types\Type;

try {
    Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
} catch (\Doctrine\DBAL\Exception $e) {
}