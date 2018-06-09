<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 09/06/18
 * Time: 16:44
 */

namespace App\Blog\Actions;

use App\Blog\Table\CategoryTable;
use App\Framework\Actions\CrudAction;
use App\Framework\Session\FlashService;
use App\Framework\Validator;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CategoryCrudAction
 * @package App\Blog\Actions
 */
class CategoryCrudAction extends CrudAction
{

    /**
     * @var string
     */
    protected $viewPath = '@blog/admin/categories';

    /**
     * @var string
     */
    protected $routePrefix = 'blog.category.admin';

    /**
     * CategoryCrudAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param CategoryTable $table
     * @param FlashService $flash
     */
    public function __construct(RendererInterface $renderer, Router $router, CategoryTable $table, FlashService $flash)
    {
        parent::__construct($renderer, $router, $table, $flash);
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    protected function getParams(ServerRequestInterface $request): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return \in_array($key, ['name', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Validator
     */
    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return parent::getValidator($request)
            ->required('name', 'slug')
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug');
    }
}
