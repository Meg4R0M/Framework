<?php
/**
 * Created by PhpStorm.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 06:56
 */

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Class Router
 * @package Framework
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function get(string $path, $callable, string $name): void
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleWare(),
                $result->getMatchedParams()
            );
        }
        return null;
    }
}
