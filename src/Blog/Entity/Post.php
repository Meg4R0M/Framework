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
     * @var
     */
    public $image;

    /**
     * @param $datetime
     */
    public function setCreatedAt($datetime): void
    {
        if (\is_string($datetime)) {
            $this->createdAt = new \DateTime($datetime);
        } else {
            $this->createdAt = $datetime;
        }
    }

    /**
     * @param $datetime
     */
    public function setUpdatedAt($datetime): void
    {
        if (\is_string($datetime)) {
            $this->updatedAt = new \DateTime($datetime);
        } else {
            $this->updatedAt = $datetime;
        }
    }

    /**
     * @return string
     */
    public function getThumb(): string
    {
        ['filename' => $filename, 'extension' => $extension] = pathinfo($this->image);
        return '/uploads/posts/' . $filename . '_thumb.' . $extension;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return '/uploads/posts/' . $this->image;
    }
}
