<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 23:23
 */

namespace App\Framework\Session;

/**
 * Class FlashService
 *
 * @package App\Framework\Session
 */
class FlashService
{

    /**
     *
     * @var SessionInterface
     */
    private $session;

    /**
     *
     * @var
     */
    private $messages;

    /**
     *
     * @var string
     */
    private $sessionKey = 'flash';


    /**
     * FlashService constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }//end __construct()


    /**
     *
     * @param string $message
     */
    public function success(string $message)
    {
        $flash            = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }//end success()


    /**
     *
     * @param string $message
     */
    public function error(string $message)
    {
        $flash          = $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }//end error()


    /**
     *
     * @param  string $type
     * @return null|string
     */
    public function get(string $type): ?string
    {
        if (is_null($this->messages)) {
            $this->messages = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
        if (array_key_exists($type, $this->messages)) {
            return $this->messages[$type];
        }
        return null;
    }//end get()
}//end class
