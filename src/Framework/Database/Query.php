<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 17/06/18
 * Time: 20:33
 */

namespace App\Framework\Database;

/**
 * Class Query
 * @package App\Framework\Database
 */
class Query
{

    /**
     * @var
     */
    private $select;

    /**
     * @var
     */
    private $from;

    /**
     * @var
     */
    private $where = [];

    /**
     * @var
     */
    private $entity;

    /**
     * @var
     */
    private $group;

    /**
     * @var
     */
    private $order;

    /**
     * @var
     */
    private $limit;

    /**
     * @var null|\PDO
     */
    private $pdo;

    /**
     * @var
     */
    private $params;

    /**
     * Query constructor.
     * @param null|\PDO $pdo
     */
    public function __construct(?\PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $table
     * @param null|string $alias
     * @return Query
     */
    public function from(string $table, ?string $alias = null): self
    {
        if ($alias) {
            $this->from[$alias] = $table;
        } else {
            $this->from[] = $table;
        }
        return $this;
    }

    /**
     * @param string ...$fields
     * @return Query
     */
    public function select(string ...$fields): self
    {
        $this->select = $fields;
        return $this;
    }

    /**
     * @param string ...$condition
     * @return Query
     */
    public function where(string ...$condition): self
    {
        $this->where = array_merge($this->where, $condition);
        return $this;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $this->select('COUNT(id)');
        return $this->execute()->fetchColumn();
    }

    /**
     * @param array $params
     * @return Query
     */
    public function params(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param string $entity
     * @return Query
     */
    public function into(string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return QueryResult
     */
    public function all(): QueryResult
    {
        return new QueryResult(
            $this->execute()->fetchAll(\PDO::FETCH_ASSOC),
            $this->entity
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $parts = ['SELECT'];
        if ($this->select) {
            $parts[] = implode(', ', $this->select);
        } else {
            $parts[] = '*';
        }
        $parts[] = 'FROM';
        $parts[] = $this->buildFrom();
        if (!empty($this->where)) {
            $parts[] = 'WHERE';
            $parts[] = '(' . implode(') AND (', $this->where) . ')';
        }
        return implode(' ', $parts);
    }

    /**
     * @return string
     */
    private function buildFrom(): string
    {
        $from = [];
        foreach ($this->from as $key => $value) {
            if (\is_string($key)) {
                $from[] = "$value as $key";
            } else {
                $from[] = $value;
            }
        }
        return implode(', ', $from);
    }

    /**
     * @return bool|\PDOStatement
     */
    private function execute()
    {
        $query = $this->__toString();
        if ($this->params) {
            $statement = $this->pdo->prepare($query);
            $statement->execute($this->params);
            return $statement;
        }
        return $this->pdo->query($query);
    }
}
