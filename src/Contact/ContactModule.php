<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 27/06/18
 * Time: 06:58
 */

namespace App\Contact;

use App\Framework\Middleware\CombinedMiddleware;
use App\Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

class ContactModule extends Module
{

    const DEFINITIONS = __DIR__.'/definitions.php';


    public function __construct(Router $router, RendererInterface $renderer, ContainerInterface $container)
    {
        $renderer->addPath('contact', __DIR__);
        $router->get('/contact', new CombinedMiddleware($container, [ContactAction::class]), 'contact');
        $router->post('/contact', new CombinedMiddleware($container, [ContactAction::class]));
    }//end __construct()
}//end class
