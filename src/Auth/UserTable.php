<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 20/06/18
 * Time: 11:51
 */

namespace App\Auth;

use App\Framework\Database\Table;

class UserTable extends Table
{

    protected $table = 'users';

    protected $entity = User::class;
}
