<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 18/06/18
 * Time: 10:44
 */

namespace App\Framework\Database;

/**
 * Class Hydrator
 * @package App\Framework\Database
 */
class Hydrator
{

    /**
     * @param array $array
     * @param $object
     * @return mixed
     */
    public static function hydrate(array $array, $object)
    {
        $instance = new $object();
        foreach ($array as $key => $value) {
            $method = self::getSetter($key);
            if (method_exists($instance, $method)) {
                $instance->$method($value);
            } else {
                $property = lcfirst(self::getProperty($key));
                $instance->$property = $value;
            }
        }
        return $instance;
    }

    /**
     * @param string $fieldName
     * @return string
     */
    private static function getSetter(string $fieldName): string
    {
        return 'set' . self::getProperty($fieldName);
    }

    /**
     * @param string $fieldName
     * @return string
     */
    private static function getProperty(string $fieldName): string
    {
        return implode('', array_map('ucfirst', explode('_', $fieldName)));
    }
}
