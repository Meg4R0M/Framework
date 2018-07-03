<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 06:51
 */

namespace App\Auth;

use App\Framework\Auth\User as UserInterface;

/**
 * Class User
 * @package App\Auth
 */
class User implements UserInterface
{

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $passwordReset;

    /**
     * @var
     */
    public $passwordResetAt;

    /**
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }//end getUsername()

    /**
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return [];
    }//end getRoles()

    /**
     *
     * @return mixed
     */
    public function getPasswordReset()
    {
        return $this->passwordReset;
    }//end getPasswordReset()

    /**
     *
     * @param mixed $passwordReset
     */
    public function setPasswordReset($passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }//end setPasswordReset()

    /**
     * @param $date
     */
    public function setPasswordResetAt($date)
    {
        if (is_string($date)) {
            $this->passwordResetAt = new \DateTime($date);
        } else {
            $this->passwordResetAt = $date;
        }
    }//end setPasswordResetAt()

    /**
     *
     * @return mixed
     */
    public function getPasswordResetAt(): ?\DateTime
    {
        return $this->passwordResetAt;
    }//end getPasswordResetAt()

    /**
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }//end getEmail()

    /**
     *
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }//end setEmail()

    /**
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }//end getPassword()

    /**
     *
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }//end setPassword()

    /**
     *
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }//end getId()

    /**
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }//end setId()
}//end class
