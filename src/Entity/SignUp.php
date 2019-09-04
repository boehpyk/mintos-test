<?php
// This is the class that will receive the form data and
// validate it with the Validator component using constrains
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

class SignUp
{
    /**
     * @Assert\NotBlank(message="Email address is required")
     * @Assert\Email(
     *     message="This email is not valid"
     * )
     * @AppAssert\EmailExists
     */
    protected $email;

    /**
     * @Assert\NotBlank(message="Password is required")
     * @Assert\Length(
     *     min = 6,
     *     minMessage="The password should be at least 6 characters long",
     * )
     */
    protected $password;


    /**
     * @return string
     */
    public function getEmail():string
    {
        return $this->email;
    }
    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getPassword():string
    {
        return $this->password;
    }
    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}