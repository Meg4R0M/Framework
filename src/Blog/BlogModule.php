<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 20:53
 */
namespace App\Blog;

use Framework\Renderer;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BlogModule
 * @package App\Blog
 */
class BlogModule
{

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * BlogModule constructor.
     * @param Router $router
     * @param Renderer $renderer
     */
    public function __construct(Router $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-0-9]+}', [$this, 'show'], 'blog.show');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        return $this->renderer->render('@blog/index');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function show(Request $request): string
    {
        return $this->renderer->render('@blog/show', [
            'slug' => $request->getAttribute('slug')
        ]);
    }
}
