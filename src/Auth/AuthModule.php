<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 06:38
 */

namespace App\Auth;

use App\Auth\Action\LoginAction;
use App\Auth\Action\LoginAttemptAction;
use App\Auth\Action\LogoutAction;
use App\Auth\Action\PasswordForgetAction;
use App\Auth\Action\PasswordResetAction;
use App\Framework\Middleware\CombinedMiddleware;
use App\Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

class AuthModule extends Module
{

    /**
     *
     */
    const DEFINITIONS = __DIR__.'/config.php';

    const MIGRATIONS = __DIR__.'/db/migrations';

    const SEEDS = __DIR__.'/db/seeds';


    public function __construct(ContainerInterface $container, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('auth', __DIR__.'/views');
        $router->get(
            $container->get('auth.login'),
            new CombinedMiddleware($container, [LoginAction::class]),
            'auth.login'
        );
        $router->post(
            $container->get('auth.login'),
            new CombinedMiddleware($container, [LoginAttemptAction::class])
        );
        $router->post(
            '/logout',
            new CombinedMiddleware($container, [LogoutAction::class]),
            'auth.logout'
        );
        $router->any(
            '/password',
            new CombinedMiddleware($container, [PasswordForgetAction::class]),
            'auth.password'
        );
        $router->any(
            '/password/reset/{id:\d+}/{token}',
            new CombinedMiddleware($container, [PasswordResetAction::class]),
            'auth.reset'
        );
    }//end __construct()
}//end class
