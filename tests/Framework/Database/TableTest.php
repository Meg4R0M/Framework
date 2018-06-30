<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 09/06/18
 * Time: 15:44
 */

namespace Tests\Framework\Database;

use App\Framework\Database\Table;
use PDO;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class TableTest
 *
 * @package Tests\Framework\Database
 */
class TableTest extends TestCase
{

    /**
     *
     * @var Table
     */
    private $table;


    /**
     *
     * @throws \ReflectionException
     */
    public function setUp()
    {
        $pdo = new PDO(
            'sqlite::memory:',
            null,
            null,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]
        );
        $pdo->exec(
            'CREATE TABLE test (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255)
        )'
        );

        $this->table = new Table($pdo);
        $reflection  = new \ReflectionClass($this->table);
        $property    = $reflection->getProperty('table');
        $property->setAccessible(true);
        $property->setValue($this->table, 'test');
    }//end setUp()


    /**
     *
     */
    public function testFind()
    {
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $test = $this->table->find(1);
        $this->assertInstanceOf(stdClass::class, $test);
        $this->assertEquals('a1', $test->name);
    }//end testFind()


    /**
     *
     */
    public function testFindList()
    {
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertEquals(['1' => 'a1', '2' => 'a2'], $this->table->findList());
    }//end testFindList()


    /**
     *
     */
    public function testFindAll()
    {
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $categories = $this->table->findAll()->fetchAll();
        $this->assertCount(2, $categories);
        $this->assertInstanceOf(stdClass::class, $categories[0]);
        $this->assertEquals('a1', $categories[0]->name);
        $this->assertEquals('a2', $categories[1]->name);
    }//end testFindAll()


    /**
     *
     */
    public function testFindBy()
    {
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $category = $this->table->findBy('name', 'a1');
        $this->assertInstanceOf(stdClass::class, $category);
        $this->assertEquals(1, (int) $category->id);
    }//end testFindBy()


    /**
     *
     */
    public function testExists()
    {
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertTrue($this->table->exists(1));
        $this->assertTrue($this->table->exists(2));
        $this->assertFalse($this->table->exists(3123));
    }//end testExists()


    /**
     *
     */
    public function testCount()
    {
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->assertEquals(3, $this->table->count());
    }//end testCount()
}//end class
