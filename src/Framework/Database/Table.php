<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 09/06/18
 * Time: 15:20
 */

namespace App\Framework\Database;

use Pagerfanta\Pagerfanta;
use PDO;

/**
 * Class Table
 * @package App\Framework\Database
 */
class Table
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Nom de la table en BDD
     *
     * @var string
     */
    protected $table;

    /**
     * Entité à utiliser
     *
     * @var string|null
     */
    protected $entity;

    /**
     * PostTable constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Pagine des elements
     *
     * @param int $perPage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            $this->paginationQuery(),
            "SELECT COUNT(id) FROM {$this->table}",
            $this->entity
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * @return string
     */
    protected function paginationQuery()
    {
        return 'SELECT * FROM ' . $this->table;
    }

    /**
     * Récupère une liste clef valeur de nos enregistrements
     *
     * @return array
     */
    public function findList(): array
    {
        $results = $this->pdo
            ->query("SELECT id, name FROM {$this->table}")
            ->fetchAll(PDO::FETCH_NUM);
        $list = [];
        foreach ($results as $result) {
            $list[$result[0]] = $result[1];
        }
        return $list;
    }

    /**
     * Récupére un élément à partir de son ID
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = $this->pdo
            ->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $query->execute([$id]);
        if ($this->entity) {
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        }
        return $query->fetch() ?: null;
    }

    /**
     * Met à jour un enregistrement au niveau de la base de données
     *
     * @param int $id
     * @param array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params["id"] = $id;
        $statement = $this->pdo->prepare("UPDATE {$this->table} SET " . $fieldQuery . " WHERE id = :id");
        return $statement->execute($params);
    }

    /**
     * Crée un nouvel enregistrement
     *
     * @param array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $fields = array_keys($params);
        $values = implode(',', array_map(function ($field) {
            return ':' . $field;
        }, $fields));
        $fields = implode(', ', $fields);
        $statement = $this->pdo->prepare("INSERT INTO {$this->table} ($fields) VALUES ($values)");
        return $statement->execute($params);
    }

    /**
     * Supprime un enregistrement
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $statement->execute([$id]);
    }

    /**
     * @param array $params
     * @return string
     */
    private function buildFieldQuery(array $params): string
    {
        return implode(',', array_map(function ($field) {
            return $field . " = :" . $field;
        }, array_keys($params)));
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Vérifie qu'un enregistrement existe
     *
     * @param $id
     * @return bool
     */
    public function exists($id): bool
    {
        $statement = $this->pdo->prepare("SELECT id FROM {$this->table} WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetchColumn() !== false;
    }
}
