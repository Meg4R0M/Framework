<?php
/**
 * Created by PhpStorm.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 06:32
 */

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;

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

    /**
     *
     */
    public function setUp()
    {
        $this->router = new Router();
    }

    /**
     * Teste si la fonction get sur l'url /blog fonctionne
     * @throws Exception
     */
    public function testGetMethod(): void
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () { return 'hello'; }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }

    /**
     * Teste si la fonction get sur une url inconnue fonctionne
     * @throws Exception
     */
    public function testGetMethodIfURLDoesNotExists(): void
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blogaze', function () { return 'hello'; }, 'blog');
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
        $this->router->get('/blog', function () { return 'azezea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
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
        $this->router->get('/blog', function () { return 'azezea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals('/blog/mon-article-18', $uri);
    }

    /**
     * Teste si la fonction get sur une url générée fonctionne
     * @throws Exception
     */
    public function testGenerateUriWithQueryParmas(): void
    {
        $this->router->get('/blog', function () { return 'azezea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $uri = $this->router->generateUri(
            'post.show',
            ['slug' => 'mon-article', 'id' => 18],
            ['p' => 2]
        );
        $this->assertEquals('/blog/mon-article-18?p=2', $uri);
    }
}
