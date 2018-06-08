<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 15:12
 */

namespace App\Blog\Entity;

use DateTime;

class Post
{

    public $id;

    public $name;

    public $slug;

    public $content;

    public $created_at;

    public $updated_at;

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
