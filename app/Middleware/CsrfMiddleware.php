<?php

declare(strict_types=1);

namespace App\Middleware;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Csrf\Guard;
use Slim\Views\Twig;

readonly class CsrfMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig      $twig,
        private Container $container
    )
    {
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $csrf = $this->container->get('csrf');

        $csrfNameKey = $csrf->getTokenNameKey();
        $csrfValueKey = $csrf->getTokenValueKey();
        $csrfName = $csrf->getTokenName();
        $csrfValue = $csrf->getTokenValue();

        $this->twig->getEnvironment()->addGlobal('csrf', [
            'keys' => [
                'name' => $csrfNameKey,
                'value' => $csrfValueKey
            ],
            'name' => $csrfName,
            'value' => $csrfValue,
            'fields' => '
                <input type="hidden" name="' . $csrfNameKey . '" value="' . $csrfName . '">
                <input type="hidden" name="' . $csrfValueKey . '" value="' . $csrfValue . '">'
        ]);

        return $handler->handle($request);
    }
}