<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 23:00
 */

namespace App\Framework\Session;

/**
 * Interface SessionInterface
 * @package App\Framework\Session
 */
interface SessionInterface
{

    /**
     * Récupère une information en session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Ajoute une information en session
     *
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value): void;

    /**
     * Supprime une clef en session
     *
     * @param string $key
     */
    public function delete(string $key): void;
}
