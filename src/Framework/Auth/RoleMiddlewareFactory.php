<?php

namespace Framework\Auth;

use App\Framework\Auth;
use App\Framework\Auth\RoleMiddleware;

/**
 * Class RoleMiddlewareFactory
 * @package Framework\Auth
 */
class RoleMiddlewareFactory
{

    /**
     * @var Auth
     */
    private $auth;

    /**
     * RoleMiddlewareFactory constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $role
     * @return RoleMiddleware
     */
    public function makeForRole($role): RoleMiddleware
    {
        return new RoleMiddleware($this->auth, $role);
    }
}
