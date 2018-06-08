<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 16:11
 */

namespace Test\App\Blog\Table;

use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Tests\DatabaseTestCase;

/**
 * Class PostTableTest
 * @package Test\App\Blog\Table
 */
class PostTableTest extends DatabaseTestCase
{
    /**
     * @var PostTable
     */
    private $postTable;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->postTable = new PostTable($this->pdo);
    }

    /**
     *
     */
    public function testFind()
    {
        $this->seedDatabase();
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    /**
     *
     */
    public function testFindNotFoundRecord()
    {
        $post = $this->postTable->find(10000000);
        $this->assertNull($post);
    }
}