<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 16:56
 */

namespace App\Framework\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class MiddlewareApp
 * @package App\Framework\Router
 */
class MiddlewareApp implements MiddlewareInterface
{

    /**
     *
     * @var callable
     */
    private $callback;

    /**
     * MiddlewareApp constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }//end __construct()

    /**
     *
     * @param  ServerRequestInterface       $request
     * @param  RequestHandlerInterface|null $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
        return $this->process($request, $handler);
    }//end process()

    /**
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }//end getCallback()
}//end class
