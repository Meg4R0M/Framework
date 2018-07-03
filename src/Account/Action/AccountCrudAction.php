<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 01/07/18
 * Time: 18:24
 */

namespace App\Account\Action;

use App\Auth\User;
use App\Auth\UserTable;
use App\Framework\Actions\CrudAction;
use App\Framework\Session\FlashService;
use App\Framework\Validator;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AccountCrudAction
 * @package App\Account\Action
 */
class AccountCrudAction extends CrudAction
{

    /**
     * @var string
     */
    protected $viewPath = '@account/admin/account';

    /**
     * @var string
     */
    protected $routePrefix = 'account.admin';

    /**
     * @var UserTable
     */
    protected $table;

    /**
     * PostCrudAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param UserTable $table
     * @param FlashService $flash
     */
    public function __construct(
        RendererInterface $renderer,
        Router $router,
        UserTable $table,
        FlashService $flash
    ) {
        parent::__construct($renderer, $router, $table, $flash);
        $this->table = $table;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        return parent::delete($request);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function formParams(array $params): array
    {
        return $params;
    }

    /**
     * @return User|array
     */
    protected function getNewEntity()
    {
        $user = new User();
        return $user;
    }

    /**
     * @param ServerRequestInterface $request
     * @param User $user
     * @return array
     */
    protected function prePersist(ServerRequestInterface $request, $user): array
    {
        $params = $request->getParsedBody();
        $params = array_filter($params, function ($key) {
            return \in_array($key, ['username', 'email', 'password', 'role']);
        }, ARRAY_FILTER_USE_KEY);
        return $params;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Validator
     */
    protected function getValidator(ServerRequestInterface $request): Validator
    {
        $validator = parent::getValidator($request)
            ->required('username', 'email', 'role')
            ->unique('username', $this->table)
            ->unique('email', $this->table)
            ->email('email')
            ->length('username', 5);
        return $validator;
    }
}
