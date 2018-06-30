<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 23:28
 */

namespace App\Auth\Action;

use App\Auth\DatabaseAuth;
use App\Framework\Actions\RouterAwareAction;
use App\Framework\Response\RedirectResponse;
use App\Framework\Session\FlashService;
use App\Framework\Session\SessionInterface;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class LoginAttemptAction
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
     * @var SessionInterface
     */
    private $session;

    /**
     *
     * @var RouterInterface
     */
    private $router;

    use RouterAwareAction;


    public function __construct(
        RendererInterface $renderer,
        DatabaseAuth $auth,
        Router $router,
        SessionInterface $session
    ) {
        $this->renderer = $renderer;
        $this->auth     = $auth;
        $this->session  = $session;
        $this->router   = $router;
    }//end __construct()


    public function __invoke(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        $user   = $this->auth->login($params['username'], $params['password']);
        if ($user) {
            $path = $this->session->get('auth.redirect') ?: $this->router->generateUri('admin');
            $this->session->delete('auth.redirect');
            return new RedirectResponse($path);
        } else {
            (new FlashService($this->session))->error('Identifiant ou mot de passe incorrect');
            return $this->redirect('auth.login');
        }
    }//end __invoke()
}//end class
