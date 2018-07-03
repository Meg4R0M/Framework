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
use Ramsey\Uuid\Uuid;

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

    /**
     * @param int $id
     * @return string
     */
    public function resetPassword(int $id): string
    {
        $token = Uuid::uuid4()->toString();
        $this->update($id, [
            'password_reset' => $token,
            'password_reset_at' => date('Y-m-d H:i:s')
        ]);
        return $token;
    }

    /**
     * @param int $id
     * @param string $password
     */
    public function updatePassword(int $id, string $password): void
    {
        $this->update($id, [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'password_reset' => null,
            'password_reset_at' => null
        ]);
    }
}//end class
