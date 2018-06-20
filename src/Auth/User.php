<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 06:51
 */

namespace App\Auth;

use App\Framework\Auth\User as UserInterface;

class User implements UserInterface
{

    public $id;

    public $username;

    public $email;

    public $password;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return [];
    }
}