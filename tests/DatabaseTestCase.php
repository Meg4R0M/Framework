<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 16:53
 */

namespace Tests;

use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class DatabaseTestCase
 * @package Tests
 */
class DatabaseTestCase extends TestCase
{
    /**
     * @return PDO
     */
    public function getPDO () {
        return new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }

    /**
     * @param PDO $pdo
     * @return Manager
     */
    public function getManager (PDO $pdo) {
        $configArray = require('phinx.php');
        $configArray['environments']['test'] = [
            'adapter'    => 'sqlite',
            'connection' => $pdo
        ];
        $config = new Config($configArray);
        return new Manager($config, new StringInput(' '), new NullOutput());
    }

    /**
     * @param PDO $pdo
     */
    public function migrateDatabase(PDO $pdo)
    {
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
        $this->getManager($pdo)->migrate('test');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * @param PDO $pdo
     */
    public function seedDatabase(PDO $pdo)
    {
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
        $this->getManager($pdo)->migrate('test');
        $this->getManager($pdo)->seed('test');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
}