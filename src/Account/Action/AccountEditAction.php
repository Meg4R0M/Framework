<?php
namespace App\Account\Action;

use App\Auth\UserTable;
use App\Framework\Auth;
use Framework\Renderer\RendererInterface;
use App\Framework\Response\RedirectResponse;
use App\Framework\Session\FlashService;
use App\Framework\Validator;
use Psr\Http\Message\ServerRequestInterface;

class AccountEditAction
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
     * @var FlashService
     */
    private $flashService;
    /**
     * @var UserTable
     */
    private $userTable;

    public function __construct(
        RendererInterface $renderer,
        Auth $auth,
        FlashService $flashService,
        UserTable $userTable
    ) {
    
        $this->renderer = $renderer;
        $this->auth = $auth;
        $this->flashService = $flashService;
        $this->userTable = $userTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $user = $this->auth->getUser();
        $params = $request->getParsedBody();
        $validator = (new Validator($params))
            ->confirm('password')
            ->required('firstname', 'lastname');
        if ($validator->isValid()) {
            $userParams = [
                'firstname' => $params['firstname'],
                'lastname'  => $params['lastname']
            ];
            if (!empty($params['password'])) {
                $userParams['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
            }
            $this->userTable->update($user->id, $userParams);
            $this->flashService->success('Votre compte a bien été mis à jour');
            return new RedirectResponse($request->getUri()->getPath());
        }
        $errors = $validator->getErrors();
        return $this->renderer->render('@account/account', compact('user', 'errors'));
    }
}
