<?php
namespace App\Auth\Action;

use App\Auth\User;
use App\Auth\UserTable;
use Framework\Renderer\RendererInterface;
use App\Framework\Response\RedirectResponse;
use Framework\Router;
use App\Framework\Session\FlashService;
use App\Framework\Validator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PasswordResetAction
 * @package App\Auth\Action
 */
class PasswordResetAction
{

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var UserTable
     */
    private $userTable;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var FlashService
     */
    private $flashService;

    /**
     * PasswordResetAction constructor.
     * @param RendererInterface $renderer
     * @param UserTable $userTable
     * @param FlashService $flashService
     * @param Router $router
     */
    public function __construct(
        RendererInterface $renderer,
        UserTable $userTable,
        FlashService $flashService,
        Router $router
    ) {
    
        $this->renderer = $renderer;
        $this->userTable = $userTable;
        $this->router = $router;
        $this->flashService = $flashService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return RedirectResponse|string
     * @throws \App\Framework\Database\NoRecordException
     */
    public function __invoke(ServerRequestInterface $request)
    {
        /** @var User $user */
        $user = $this->userTable->find($request->getAttribute('id'));
        if ($user->getPasswordReset() !== null &&
            $user->getPasswordReset() === $request->getAttribute('token') &&
            time() - $user->getPasswordResetAt()->getTimestamp() < 600
        ) {
            if ($request->getMethod() === 'GET') {
                return $this->renderer->render('@auth/reset');
            }

            $params = $request->getParsedBody();
            $validator = (new Validator($params))
                ->length('password', 4)
                ->confirm('password');
            if ($validator->isValid()) {
                $this->userTable->updatePassword($user->getId(), $params['password']);
                $this->flashService->success('Votre mot de passe a bien été changé');
                return new RedirectResponse($this->router->generateUri('auth.login'));
            }

            $errors = $validator->getErrors();
            return $this->renderer->render('@auth/reset', compact('errors'));
        }

        $this->flashService->error('Token invalid');
        return new RedirectResponse($this->router->generateUri('auth.password'));
    }
}
