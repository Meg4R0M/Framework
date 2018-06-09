<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 12:31
 */

namespace  App\Blog\Table;

use App\Blog\Entity\Post;
use App\Framework\Database\Table;

/**
 * Class PostTable
 * @package App\Blog\Table
 */
class PostTable extends Table
{

    /**
     * @var string
     */
    protected $entity = Post::class;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @return string
     */
    protected function paginationQuery()
    {
        return "SELECT p.id, p.name, c.name category_name 
        FROM {$this->table} AS p
        LEFT JOIN categories AS c ON p.category_id = c.id
        ORDER BY created_at DESC";
    }
}
