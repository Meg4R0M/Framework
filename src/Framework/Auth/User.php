<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 06:24
 */

namespace App\Framework\Auth;

/**
 * Interface User
 * @package App\Framework\Auth
 */
interface User
{

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string[]
     */
    public function getRoles(): array;

}
