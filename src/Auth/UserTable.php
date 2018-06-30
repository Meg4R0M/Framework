<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 20/06/18
 * Time: 11:51
 */

namespace App\Auth;

use App\Framework\Database\Table;
use PDO;

/**
 * Class UserTable
 * @package App\Auth
 */
class UserTable extends Table
{

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * UserTable constructor.
     * @param PDO $pdo
     * @param string $entity
     */
    public function __construct(PDO $pdo, string $entity = User::class)
    {
        $this->entity = $entity;
        parent::__construct($pdo);
    }
}//end class
