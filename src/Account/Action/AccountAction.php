<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 30/06/18
 * Time: 22:52
 */

namespace App\Account\Action;

use App\Framework\Auth;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AccountAction
 * @package App\Account\Action
 */
class AccountAction
{

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * AccountAction constructor.
     * @param RendererInterface $renderer
     * @param Auth $auth
     */
    public function __construct(
        RendererInterface $renderer,
        Auth $auth
    ) {
        $this->renderer = $renderer;
        $this->auth = $auth;
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $user = $this->auth->getUser();
        return $this->renderer->render('@account/account', compact('user'));
    }
}
