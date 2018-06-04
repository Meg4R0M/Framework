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
 * @package Framework\Router
 */
class Route
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string[]
     */
    private $parameters;

    /**
     * Route constructor.
     * @param string $name
     * @param callable|string $callback
     * @param array $parameters
     */
    public function __construct(string $name, $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
