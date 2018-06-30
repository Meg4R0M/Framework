<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 27/06/18
 * Time: 06:58
 */

namespace App\Contact;

use App\Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;

class ContactModule extends Module
{

    const DEFINITIONS = __DIR__.'/definitions.php';


    public function __construct(Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('contact', __DIR__);
        $router->get('/contact', ContactAction::class, 'contact');
        $router->post('/contact', ContactAction::class);
    }//end __construct()
}//end class
