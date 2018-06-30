<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 01/07/18
 * Time: 00:08
 */

namespace App\Framework\Auth;

use App\Framework\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoleMiddleware implements MiddlewareInterface
{

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var string
     */
    private $role;

    public function __construct(Auth $auth, string $role)
    {
        $this->auth = $auth;
        $this->role = $role;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws ForbiddenException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->auth->getUser();
        if ($user === null || !\in_array($this->role, $user->getRoles(), true)) {
            throw new ForbiddenException();
        }
        return $handler->handle($request);
    }
}
