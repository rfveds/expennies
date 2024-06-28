<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/container_bindings.php');

try {
    return $containerBuilder->build();
} catch (Exception $e) {
}
