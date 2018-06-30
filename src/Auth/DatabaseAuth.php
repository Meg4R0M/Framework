<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 06:56
 */

namespace App\Auth;

use App\Framework\Auth;
use App\Framework\Auth\User;
use App\Framework\Database\NoRecordException;
use App\Framework\Session\SessionInterface;

class DatabaseAuth implements Auth
{

    /**
     * @var UserTable
     */
    private $userTable;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var User
     */
    private $user;

    public function __construct(UserTable $userTable, SessionInterface $session)
    {
        $this->userTable = $userTable;
        $this->session = $session;
    }

    public function login(string $username, string $password): ?User
    {
        if (empty($username) || empty($password)) {
            return null;
        }

        /** @var \App\Auth\User $user */
        $user = $this->userTable->findBy('username', $username);
        if ($user && password_verify($password, $user->password)) {
            $this->session->set('auth.user', $user->id);
            return $user;
        }

        return null;
    }

    public function logout(): void
    {
        $this->session->delete('auth.user');
    }

    /**
     * @return User|null
     * @throws \App\Framework\Database\NoRecordException
     */
    public function getUser(): ?User
    {
        if ($this->user) {
            return $this->user;
        }
        $userId = $this->session->get('auth.user');
        if ($userId) {
            try {
                $this->user = $this->userTable->find($userId);
                return $this->user;
            } catch (NoRecordException $exception) {
                $this->session->delete('auth.user');
                return null;
            }
        }
        return null;
    }
}
