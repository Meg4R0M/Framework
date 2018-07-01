<?php
/**
 * Created by PhpStorm.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 06:32
 */

namespace Tests\Framework;

use App\Blog\Actions\CategoryShowAction;
use App\Framework\Middleware\CombinedMiddleware;
use App\Framework\Router\MiddlewareApp;
use DI\Container;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class RouterTest
 * @package Tests\Framework
 */
class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    private $fakeCallable;

    private $fakeCallable2;

    /**
     *
     */
    public function setUp()
    {
        $this->router = new Router();
        $this->fakeCallable = function() {
            return 'hello';
        };
    }

    /**
     * Teste si la fonction get sur l'url /blog fonctionne
     */
    public function testGetMethod(): void
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        //$this->assertEquals('hello', \call_user_func_array($route->getCallback(), [$request]));
    }

    public function testPostDeleteMethod()
    {
        $fake = function () {
            return 'hello';
        };
        $this->router->get('/blog', $fake, 'blog');
        $this->router->post('/blog', $fake, 'blog.post');
        $this->router->delete('/blog', $fake, 'blog.delete');
        $this->assertEquals('blog', $this->router->match(new ServerRequest('GET', '/blog'))->getName());
        $this->assertEquals('blog.post', $this->router->match(new ServerRequest('POST', '/blog'))->getName());
        $this->assertEquals('blog.delete', $this->router->match(new ServerRequest('DELETE', '/blog'))->getName());
    }

    public function testCrudMethod()
    {
        $this->router->crud('/blog', function () {
        }, 'blog');
        $this->assertEquals('blog.index', $this->router->match(new ServerRequest('GET', '/blog'))->getName());
        $this->assertEquals('blog.create', $this->router->match(new ServerRequest('GET', '/blog/new'))->getName());
        $this->assertInstanceOf(Router\Route::class, $this->router->match(new ServerRequest('POST', '/blog/new')));
        $this->assertEquals('blog.edit', $this->router->match(new ServerRequest('GET', '/blog/1'))->getName());
        $this->assertInstanceOf(Router\Route::class, $this->router->match(new ServerRequest('POST', '/blog/1')));
        $this->assertInstanceOf(Router\Route::class, $this->router->match(new ServerRequest('DELETE', '/blog/1')));
    }

    /**
     * Teste si la fonction get sur une url inconnue fonctionne
     * @throws Exception
     */
    public function testGetMethodIfURLDoesNotExists(): void
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blogaze', function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    /**
     * Teste si la fonction get sur une url disposant d'un slug fonctionne
     * @throws Exception
     */
    public function testGetMethodWithParameters(): void
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        $this->router->get('/blog', function () {
            return 'azezea';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        //$this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParams());
        // test url invalide
        $route = $this->router->match(new ServerRequest('GET', '/blog/mon_slug-8'));
        $this->assertEquals(null, $route);
    }

    /**
     * Teste si la fonction get sur une url générée fonctionne
     * @throws Exception
     */
    public function testGenerateUri(): void
    {
        $this->router->get('/blog', function () {
            return 'azezea';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals('/blog/mon-article-18', $uri);
    }

    /**
     * Teste si la fonction get sur une url générée fonctionne
     * @throws Exception
     */
    public function testGenerateUriWithQueryParmas(): void
    {
        $this->router->get('/blog', function () {
            return 'azezea';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri(
            'post.show',
            ['slug' => 'mon-article', 'id' => 18],
            ['p' => 2]
        );
        $this->assertEquals('/blog/mon-article-18?p=2', $uri);
    }
}
