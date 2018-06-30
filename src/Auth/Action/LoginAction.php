<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 23:28
 */

namespace App\Auth\Action;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginAction
{

    /**
     *
     * @var RendererInterface
     */
    private $renderer;


    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }//end __construct()


    public function __invoke(ServerRequestInterface $request)
    {
        return $this->renderer->render('@auth/login');
    }//end __invoke()
}//end class
