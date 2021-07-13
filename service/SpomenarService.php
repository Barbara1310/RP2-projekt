<?php

require_once __SITE_PATH . '/app/database/db.class.php';
require_once __SITE_PATH . '/model/Pitanje.php';

class SpomenarService
{
    // Funckija za dohvat svih pitanja iz tablice p_questions.
    // Funckija se poziva kad je potrebno znati koliko ukupno pitanja ima u spomenaru.
    // Funckija vraca listu pitanja.
    static function getPitanjaAll()
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_questions');
        $st->execute([]);

        $pitanja = array();
        while ($row = $st->fetch()) {
            $pitanja[] = new Pitanje($row['id'], $row['question']);;
        }
        return $pitanja;
    }

    // Funkcija za dohvat rednog broja pitanja iz tablice p_questions. Kljuc za pretragu je pitanje.
    // Funckija vraca redni broj pitanja.
    static function getPitanjeId($pitanje)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_questions WHERE question LIKE :pitanje');
        $st->execute(['pitanje' => $pitanje]);

        $row = $st->fetch();

        return $row['id'];
    }

    // Funckija za dohvat pitanja po njegovom rednom broju iz tablice p_questions.
    // FUnckija vraca klasu pitanje.
    static function getPitanjeById($pitanje_id)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_questions WHERE id LIKE :pitanje_id');
        $st->execute(['pitanje_id' => $pitanje_id]);

        $row = $st->fetch();
        $pitanje = new Pitanje($pitanje_id, $row['question']);
        return $pitanje;
    }

    // Funckija koja dohvaca sve odgovore na jedno pitanje. Odgovori se traze u tablici p_answers.
    // Kljuc pretrage je redni broj pitanja.
    // Funkcija vraca listu odgovora na pitanje.
    static function getOdgovoriByPitanjeId($pitanje_id)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_answers WHERE id_question LIKE :pitanje_id');
        $st->execute(['pitanje_id' => $pitanje_id]);
        $odgovori = array();
        while ($row = $st->fetch()) {
            $odgovori[] = $row['answer'];
        }
        return $odgovori;
    }

    // Funckija za dohvat odgovora na pitanje za trenutnog korisnika.
    // Argumenti funkcije su user_id i pitanje_id koji su kljucevi pretrage.
    // Funkcija vraca listu odgovora (iako je odgovor uvijek 1). Lista je koristena kako bi prikaz odogovra bio isti
    // i kad se radi o vise odgovora i kad se radi o jednom odgovoru trenutnog korisnika.
    static function getOdgovorByUserId($user_id, $pitanje_id)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_answers WHERE id_user LIKE :user_id AND id_question LIKE :pitanje_id');
        $st->execute(['user_id' => $user_id, 'pitanje_id' => $pitanje_id]);
        $odgovori = array();
        while ($row = $st->fetch()) {
            $odgovori[] = $row['answer'];
        }
        return $odgovori;
    }

    // Funckija koja sprema odgovor na pitanje trenutnog korisnika.
    // Odgovor na pitanje se sprema u tablicu p_answers. U tablicu se sprema odgovor, redni broj pitanja na koje se
    // odgovor odnosi te redni broj usera.
    static function setOdgovorByUserId($user_id, $pitanje_id, $odgovor)
    {
        $db = DB::getConnection();
        $st = $db->prepare('INSERT INTO p_answers (id_question, answer, id_user) VALUES (:pitanje_id, :answer, :user_id)');
        $st->execute(['pitanje_id' => $pitanje_id, 'answer' => $odgovor, 'user_id' => $user_id]);
    }

    // Funckija koja dodaje novo pitanje u tablicu p_questions.
    static function addNewQuestion($question)
    {
        $db = DB::getConnection();
        $st = $db->prepare('INSERT INTO p_questions (question) VALUES (:question)');
        $st->execute(['question' => $question]);
    }
}
