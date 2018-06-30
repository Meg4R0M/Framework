<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 23:09
 */

namespace App\Framework\Session;

class PHPSession implements SessionInterface, \ArrayAccess
{


    /**
     * Assure que la session est démarrée
     */
    private function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }//end ensureStarted()


    /**
     * Récupère une information en session
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }//end get()


    /**
     * Ajoute une information en session
     *
     * @param  string $key
     * @param  $value
     * @return mixed
     */
    public function set(string $key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }//end set()


    /**
     * Supprime une clef en session
     *
     * @param string $key
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }//end delete()


    /**
     * Whether a offset exists
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param  mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since  5.0.0
     */
    public function offsetExists($offset): bool
    {
        $this->ensureStarted();
        return array_key_exists($offset, $_SESSION);
    }//end offsetExists()


    /**
     * Offset to retrieve
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetget.php
     * @param  mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since  5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }//end offsetGet()


    /**
     * Offset to set
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetset.php
     * @param  mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param  mixed $value  <p>
     *  The value to set.
     *  </p>
     * @return void
     * @since  5.0.0
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }//end offsetSet()


    /**
     * Offset to unset
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param  mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since  5.0.0
     */
    public function offsetUnset($offset): void
    {
        $this->delete($offset);
    }//end offsetUnset()
}//end class
