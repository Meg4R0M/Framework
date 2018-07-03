<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 14:00
 */

namespace App\Framework\Database;

use Pagerfanta\Adapter\AdapterInterface;
use PDO;

/**
 * Class PaginatedQuery
 *
 * @package App\Framework\Database
 */
class PaginatedQuery implements AdapterInterface
{

    /**
     *
     * @var Query
     */
    private $query;

    /**
     * PaginatedQuery constructor.
     *
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }//end __construct()

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults(): int
    {
        return $this->query->count();
    }//end getNbResults()

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return QueryResult The slice.
     */
    public function getSlice($offset, $length): QueryResult
    {
        $query = clone $this->query;
        return $query->limit($length, $offset)->fetchAll();
    }//end getSlice()
}//end class
