<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 18/06/18
 * Time: 10:44
 */

namespace App\Framework\Database;

/**
 * Transforme un tableau en objet en utilisant les setters
 *
 * Class Hydrator
 *
 * @package App\Framework\Database
 */
class Hydrator
{

    /**
     * Transforme un tableau en objet en utilisant les setters
     *
     * @param  array  $array
     * @param  $object
     * @return mixed
     */
    public static function hydrate(array $array, $object)
    {
        if (\is_string($object)) {
            $instance = new $object();
        } else {
            $instance = $object;
        }
        foreach ($array as $key => $value) {
            $method = self::getSetter($key);
            if (method_exists($instance, $method)) {
                $instance->$method($value);
            } else {
                $property            = lcfirst(self::getProperty($key));
                $instance->$property = $value;
            }
        }
        return $instance;
    }//end hydrate()

    /**
     *
     * @param  string $fieldName
     * @return string
     */
    private static function getSetter(string $fieldName): string
    {
          return 'set'.self::getProperty($fieldName);
    }//end getSetter()

    /**
     *
     * @param  string $fieldName
     * @return string
     */
    private static function getProperty(string $fieldName): string
    {
        return implode('', array_map('ucfirst', explode('_', $fieldName)));
    }//end getProperty()
}//end class
