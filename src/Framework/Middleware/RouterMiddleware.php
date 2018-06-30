<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 14:33
 */

namespace App\Framework\Middleware;

use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class RouterMiddleware
{

    /**
     *
     * @var Router
     */
    private $router;


    public function __construct(Router $router)
    {
        $this->router = $router;
    }//end __construct()


    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $route = $this->router->match($request);
        if (is_null($route)) {
            return $next($request);
        }
        $params  = $route->getParams();
        $request = array_reduce(
            array_keys($params),
            function ($request, $key) use ($params) {
                return $request->withAttribute($key, $params[$key]);
            },
            $request
        );
        $request = $request->withAttribute(get_class($route), $route);
        return $next($request);
    }//end __invoke()
}//end class
