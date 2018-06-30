<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 18/06/18
 * Time: 10:14
 */

namespace Tests\Framework\Database;

/**
 * Class Demo
 *
 * @package Tests\Framework\Database
 */
class Demo
{

    /**
     *
     * @var
     */
    private $slug;


    /**
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }//end getSlug()


    /**
     *
     * @param $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug.'demo';
    }//end setSlug()
}//end class
