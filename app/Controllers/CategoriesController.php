<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\DataObjects\Category\CreateCategoryData;
use App\DataObjects\Category\UpdateCategoryData;
use App\RequestValidators\CreateCategoryRequestValidator;
use App\RequestValidators\UpdateCategoryRequestValidator;
use App\ResponseFormatter;
use App\Service\CategoryService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class CategoriesController
{
    public function __construct(
        private Twig                             $twig,
        private RequestValidatorFactoryInterface $requestValidatorFactory,
        private CategoryService                  $categoryService,
        private ResponseFormatter                $responseFormatter
    )
    {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render(
            $response,
            'categories/index.twig',
            [
                'categories' => $this->categoryService->getAll()
            ]
        );
    }

    /**
     * @throws ORMException
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $this->requestValidatorFactory->make(CreateCategoryRequestValidator::class)->validate($request->getParsedBody());

        $this->categoryService->create(
            new CreateCategoryData(
                $data['name'],
                $request->getAttribute('user')
            )
        );

        return $response->withHeader('Location', '/categories')->withStatus(302);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->categoryService->delete($args['id']);

        return $response->withHeader('Location', '/categories')->withStatus(302);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function get(Request $request, Response $response, array $args): Response
    {
        $category = $this->categoryService->getById($args['id']);

        if (!$category) {
            return $response->withStatus(404);
        }

        $data = ['id' => $category->getId()->toString(), 'name' => $category->getName()];

        return $this->responseFormatter->asJson($response, $data);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $this->requestValidatorFactory->make(UpdateCategoryRequestValidator::class)->validate(
            $args + $request->getParsedBody()
        );

        $category = $this->categoryService->getById($data['id']);

        if (!$category) {
            return $response->withStatus(404);
        }

        $this->categoryService->update(
            $category,
            new UpdateCategoryData($data['name'])
        );

        return $this->responseFormatter->asJson($response, $data);
    }

}