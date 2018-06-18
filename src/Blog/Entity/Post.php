<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 15:12
 */

namespace App\Blog\Entity;

use DateTime;

/**
 * Class Post
 * @package App\Blog\Entity
 */
class Post
{

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $slug;

    /**
     * @var
     */
    public $content;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    /**
     * @param DateTime $datetime
     */
    public function setCreatedAt(DateTime $datetime): void
    {
        if (\is_string($datetime)) {
            $this->createdAt = new DateTime($this->createdAt);
        }
    }

    /**
     * @param DateTime $datetime
     */
    public function setUpdatedAt(DateTime $datetime): void
    {
        if (\is_string($datetime)) {
            $this->updatedAt = new DateTime($this->updatedAt);
        }
    }
}
