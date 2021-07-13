<?php

require_once __SITE_PATH . '/app/database/db.class.php';
require_once __SITE_PATH . '/model/User.php';

class UserService
{
    // Dohvati usera iz p_users tablice po username-u.
    // Funckija vraca klasu User.
    static function getUserByUsername($username)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_users WHERE username LIKE :username');
        $st->execute(['username' => $username]);

        $row = $st->fetch();

        $user = new User($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['has_registered'], $row['registration_sequence'], $row['is_admin']);
        return $user;
    }

    // Dohvati usera iz p_users tablice po registrationSequence-u.
    // Funckija vraca klasu User.
    static function getUserByRegSeq($reg_seq)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_users WHERE registration_sequence LIKE :reg_seq');
        $st->execute(['reg_seq' => $reg_seq]);

        $row = $st->fetch();

        $user = new User($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['has_registered'], $row['registration_sequence'], $row['is_admin']);
        return $user;
    }

    // Spremi novog usera u tablicu p_users. Funkcija se poziva prilikom registracije novog usera.
    static function saveUser($user)
    {
        $db = DB::getConnection();
        $st = $db->prepare("INSERT INTO p_users (username, password_hash, email, registration_sequence, is_admin) VALUES (:username, :password_hash, :email, :reg_seq, :is_admin)");

        $st->execute(['username' => $user->username, 'password_hash' => $user->password_hash, 'email' => $user->email, 'reg_seq' => $user->registration_sequence, 'is_admin' => $user->is_admin]);
    }

    // Updateaj usera u tablici p_users. Funckija se poziva kad se potvrdi registracija klikom na link u mailu.
    static function updateUser($user)
    {
        $db = DB::getConnection();
        $st = $db->prepare("INSERT p_users SET has_registered = :has_registered WHERE username LIKE :username AND registration_sequence LIKE :req_seq");

        $st->execute(['has_registered' => $user->has_registered, 'username' => $user->username, 'reg_seq' => $user->registration_sequence]);
    }
}
