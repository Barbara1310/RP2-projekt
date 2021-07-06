<?php

class User
{
    protected $id, $username, $password_hash, $email, $has_registered, $registration_sequence, $is_admin;

    function __construct($id, $username, $password_hash, $email, $has_registered, $registration_sequence, $is_admin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->email = $email;
        $this->has_registered = $has_registered;
        $this->registration_sequence = $registration_sequence;
        $this->is_admin = $is_admin;
    }

    function __get($prop)
    {
        return $this->$prop;
    }
    function __set($prop, $val)
    {
        $this->$prop = $val;
        return $this;
    }
}
