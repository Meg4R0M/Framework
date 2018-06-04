<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 20:53
 */
namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BlogModule
 * @package App\Blog
 */
class BlogModule
{

    /**
     * BlogModule constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-]+}', [$this, 'show'], 'blog.show');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        return '<h1>Bienvenue sur le blog</h1>';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function show(Request $request): string
    {
        return '<h1>Bienvenue sur l\'article ' . $request->getAttribute('slug') . '</h1>';
    }
}
