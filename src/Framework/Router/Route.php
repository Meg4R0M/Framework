<?php
/**
 * Created by PhpStorm.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 07:00
 */

namespace Framework\Router;

/**
 * Class Route
 * Represent a matched route
 *
 * @package Framework\Router
 */
/**
 * Class Route
 *
 * @package Framework\Router
 */
class Route
{

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var callable
     */
    private $callback;

    /**
     *
     * @var array
     */
    private $parameters;


    /**
     * Route constructor.
     *
     * @param string          $name
     * @param string|callable $callback
     * @param array           $parameters
     */
    public function __construct(string $name, $callback, array $parameters)
    {
        $this->name       = $name;
        $this->callback   = $callback;
        $this->parameters = $parameters;
    }//end __construct()


    /**
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }//end getName()


    /**
     *
     * @return string|callable
     */
    public function getCallback()
    {
        return $this->callback;
    }//end getCallback()


    /**
     * Retrieve the URL parameters
     *
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }//end getParams()
}//end class
