<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 17/06/18
 * Time: 17:22
 */

namespace App\Framework\Router;

use Framework\Router;
use Psr\Container\ContainerInterface;

class RouterFactory
{


    public function __invoke(ContainerInterface $container)
    {
        $cache = null;
        if ($container->get('env') === 'production') {
            $cache = 'tmp/routes';
        }
        return new Router($cache);
    }//end __invoke()
}//end class
