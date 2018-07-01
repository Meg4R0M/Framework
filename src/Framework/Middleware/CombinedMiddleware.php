<?php
namespace App\Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CombinedMiddleware implements RequestHandlerInterface, MiddlewareInterface
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

    /**
     * @var RequestHandlerInterface
     */
    private $handler;

    private $index = 0;

    public function __construct(ContainerInterface $container, array $middlewares)
    {
        $this->container   = $container;
        $this->middlewares = $middlewares;
    }//end __construct()


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->handler = $handler;
        return $this->handle($request);
    }//end process()

    /**
     * Handle the request and return a response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        if (null === $middleware) {
            return $this->handler->handle($request);
        }

        if (\is_callable($middleware)) {
            $response = \call_user_func_array($middleware, [$request, [$this, 'process']]);
            if (\is_string($response)) {
                return new Response(200, [], $response);
            }
            return $response;
        }

        if ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }
    }//end handle()

    /**
     *
     * @return object
     */
    private function getMiddleware()
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            if (\is_string($this->middlewares[$this->index])) {
                $middleware = $this->container->get($this->middlewares[$this->index]);
            } else {
                $middleware = $this->middlewares[$this->index];
            }
            $this->index++;
            return $middleware;
        }
        return null;
    }//end getMiddleware()
}//end class
