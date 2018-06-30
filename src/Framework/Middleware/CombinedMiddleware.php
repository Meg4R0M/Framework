<?php
namespace App\Framework\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CombinedMiddleware implements MiddlewareInterface
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     *
     * @var array
     */
    private $middlewares;


    public function __construct(ContainerInterface $container, array $middlewares)
    {
        $this->container   = $container;
        $this->middlewares = $middlewares;
    }//end __construct()


    public function process(ServerRequestInterface $request, RequestHandlerInterface $delegate): ResponseInterface
    {
        $delegate = new CombinedMiddlewareDelegate($this->container, $this->middlewares, $delegate);
        return $delegate->handle($request);
    }//end process()
}//end class
