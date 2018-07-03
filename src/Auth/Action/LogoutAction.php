<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 23:28
 */

namespace App\Auth\Action;

use App\Auth\DatabaseAuth;
use App\Framework\Response\RedirectResponse;
use App\Framework\Session\FlashService;
use Framework\Renderer\RendererInterface;

/**
 * Class LogoutAction
 * @package App\Auth\Action
 */
class LogoutAction
{

    /**
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     *
     * @var DatabaseAuth
     */
    private $auth;

    /**
     *
     * @var FlashService
     */
    private $flashService;

    /**
     * LogoutAction constructor.
     * @param RendererInterface $renderer
     * @param DatabaseAuth $auth
     * @param FlashService $flashService
     */
    public function __construct(RendererInterface $renderer, DatabaseAuth $auth, FlashService $flashService)
    {
        $this->renderer     = $renderer;
        $this->auth         = $auth;
        $this->flashService = $flashService;
    }//end __construct()

    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        $this->auth->logout();
        $this->flashService->success('Vous êtes maintenant déconnecté');
        return new RedirectResponse('/');
    }//end __invoke()
}//end class
