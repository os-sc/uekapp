<?php

class user
{
    public $id;
    public $name;
    public $hashedpw;
    public $registrationDate;

    function __construct($justRegistered = false) {
        if ($justRegistered)
            $this->registrationDate = date('U');
    }

    function toArray() {
        return ['username' => $this->name,
                'hashedpw' => $this->hashedpw,
                'regdate'  => $this->registrationDate];
    }
}