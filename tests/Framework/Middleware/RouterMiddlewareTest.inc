<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 17:38
 *
 * @package Tests\Framework\Middleware
 */
namespace Tests\Framework\Middleware;

use App\Framework\Middleware\RouterMiddleware;
use Framework\Router;
use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

/**
 * Test du RouterMiddleware
 * Class RouterMiddlewareTest
 */
class RouterMiddlewareTest extends TestCase
{


    /**
     * Method pour creer un middleware avec une route
     *
     * @param  Router $route
     * @return RouterMiddleware
     */
    public function makeMiddleware($route)
    {
        $router = $this->getMockBuilder(Router::class)->getMock();
        $router->method('match')->willReturn($route);
        return new RouterMiddleware($router);
    }//end makeMiddleware()


    /**
     *
     */
    public function testPassParameters()
    {
        $route      = new Route('demo', 'trim', ['id' => 2]);
        $middleware = $this->makeMiddleware($route);
        $demo       = function ($request) use ($route) {
            $this->assertEquals(2, $request->getAttribute('id'));
            $this->assertEquals($route, $request->getAttribute(get_class($route)));
            return new Response();
        };
        call_user_func_array($middleware, [new ServerRequest('GET', '/demo'), $demo]);
    }//end testPassParameters()


    /**
     *
     */
    public function testCallNext()
    {
        $route      = new Route('demo', 'trim', ['id' => 2]);
        $middleware = $this->makeMiddleware(null);
        $response   = new Response();
        $demo       = function ($request) use ($response) {
            return $response;
        };
        $this->assertEquals($response, call_user_func_array($middleware, [new ServerRequest('GET', '/demo'), $demo]));
    }//end testCallNext()
}//end class
