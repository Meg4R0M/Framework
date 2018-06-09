<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 12:31
 */

namespace  App\Blog\Table;

use App\Blog\Entity\Post;
use App\Framework\Database\NoRecordException;
use App\Framework\Database\PaginatedQuery;
use App\Framework\Database\Table;
use Pagerfanta\Pagerfanta;

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

    public function findPaginatedPublic(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            "SELECT p.*, c.name as category_name, c.slug as category_slug
                FROM posts as p 
                LEFT JOIN categories as c ON c.id = p.category_id 
                ORDER BY p.created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->entity
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * @param int $perPage
     * @param int $currentPage
     * @param int $categoryId
     * @return Pagerfanta
     */
    public function findPaginatedPublicForCategory(int $perPage, int $currentPage, int $categoryId): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            "SELECT p.*, c.name as category_name, c.slug as category_slug
                FROM posts as p 
                LEFT JOIN categories as c ON c.id = p.category_id 
                WHERE p.category_id = :category
                ORDER BY p.created_at DESC",
            "SELECT COUNT(id) FROM {$this->table} WHERE category_id = :category",
            $this->entity,
            ['category' => $categoryId]
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NoRecordException
     */
    public function findWithCategory(int $id)
    {
        return $this->fetchOrFail('
            SELECT p.*, c.name category_name, c.slug category_slug
            FROM posts as p
            LEFT JOIN categories as c ON c.id = p.category_id
            WHERE p.id = ?
        ', [$id]);
    }

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
