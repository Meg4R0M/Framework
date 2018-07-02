<?php
namespace App\Account;

use App\Account\Action\AccountAction;
use App\Account\Action\AccountEditAction;
use App\Account\Action\SignupAction;
use App\Account\Action\AccountCrudAction;
use App\Framework\Auth\LoggedinMiddleware;
use App\Framework\Middleware\CombinedMiddleware;
use App\Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

class AccountModule extends Module
{

    const MIGRATIONS = __DIR__ . '/migrations';

    const DEFINITIONS = __DIR__ . '/definitions.php';

    public function __construct(Router $router, RendererInterface $renderer, ContainerInterface $container)
    {
        $renderer->addPath('account', __DIR__ . '/views');
        $router->get(
            '/inscription',
            new CombinedMiddleware($container, [SignupAction::class]),
            'account.signup'
        );
        $router->post(
            '/inscription',
            new CombinedMiddleware($container, [SignupAction::class])
        );
        $router->get(
            '/mon-profil',
            new CombinedMiddleware($container, [LoggedinMiddleware::class, AccountAction::class]),
            'account'
        );
        $router->post(
            '/mon-profil',
            new CombinedMiddleware($container, [LoggedinMiddleware::class, AccountEditAction::class])
        );

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud(
                $prefix.'/account',
                new CombinedMiddleware($container, [AccountCrudAction::class]),
                'account.admin'
            );
        }
    }
}
