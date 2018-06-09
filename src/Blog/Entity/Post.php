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
    public $created_at;

    /**
     * @var DateTime
     */
    public $updated_at;

    /**
     * @var
     */
    public $category_name;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        if ($this->created_at) {
            $this->created_at = new DateTime($this->created_at);
        }

        if ($this->updated_at) {
            $this->updated_at = new DateTime($this->updated_at);
        }
    }
}
