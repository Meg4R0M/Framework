<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 20:53
 */
namespace App\Blog;

use App\Blog\Actions\BlogAction;
use App\Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;

/**
 * Class BlogModule
 * @package App\Blog
 */
class BlogModule extends Module
{

    /**
     *
     */
    const DEFINITIONS = __DIR__ . '/config.php';

    /**
     * BlogModule constructor.
     * @param Router $router
     * @param RendererInterface $renderer
     */
    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__ . '/views');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix . '/{slug:[a-z\-0-9]+}', BlogAction::class, 'blog.show');
    }
}
