<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 20/06/18
 * Time: 18:18
 */

namespace App\Auth;

use App\Framework\Auth;

class AuthTwigExtension extends \Twig_Extension
{

    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('current_user', [$this->auth, 'getUser'])
        ];
    }
}
