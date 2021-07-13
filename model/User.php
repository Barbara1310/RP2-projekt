<?php

class User
{
    // Klasa User u koju se spremaju sve vrijednosti koje se mogu procitati iz tablice p_users.
    // Dodatni atribut klase je polje odgovoreno koje se koristi kako bi se oznacilo na koja je pitanja trenutni
    // korisnik dao odgovor. Ta informacija se koristi kao odluka za prikaz forme za odgovor u pitanje.php.
    // Polje odgovoreno se sastoji od onoliko elementa koliko ima odgovora. Indeks polja predstavlja redni broj pitanja,
    // dok element na indeksu predstavlja informaciju je li odgovor spremljen ili nije (1 ako je, 0 ako nije).
    protected $id, $username, $password_hash, $email, $has_registered, $registration_sequence, $is_admin, $odgovoreno;

    function __construct($id, $username, $password_hash, $email, $has_registered, $registration_sequence, $is_admin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->email = $email;
        $this->has_registered = $has_registered;
        $this->registration_sequence = $registration_sequence;
        $this->is_admin = $is_admin;
        $this->odgovoreno = array();
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

    function setPopunjeno($idx)
    {
        $this->odgovoreno[$idx] = 1;
    }
}
