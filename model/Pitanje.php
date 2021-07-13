<?php

class Pitanje
{
    // Klasa pitanje.
    // Atribut id je redni broj pitanja, atribut pitanje je stvarno pitanje.
    // Koristi se u pitanje.php, te _pitanje.php.
    protected $id, $pitanje;

    function __construct($id, $pitanje)
    {
        $this->id = $id;
        $this->pitanje = $pitanje;
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
