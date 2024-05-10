<?php

namespace App\Application\DTO;

class RegisterData
{
    public $name;
    public $email;
    public $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}