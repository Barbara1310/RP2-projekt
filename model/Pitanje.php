<?php

class Pitanje
{
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
