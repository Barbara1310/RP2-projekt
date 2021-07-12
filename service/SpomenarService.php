<?php

require_once __SITE_PATH . '/app/database/db.class.php';
require_once __SITE_PATH . '/model/Pitanje.php';

class SpomenarService
{
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

    static function getPitanjeId($pitanje)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_questions WHERE question LIKE :pitanje');
        $st->execute(['pitanje' => $pitanje]);

        $row = $st->fetch();

        return $row['id'];
    }

    static function getPitanjeById($pitanje_id)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM p_questions WHERE id LIKE :pitanje_id');
        $st->execute(['pitanje_id' => $pitanje_id]);

        $row = $st->fetch();
        $pitanje = new Pitanje($pitanje_id, $row['question']);
        return $pitanje;
    }

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

    static function setOdgovorByUserId($user_id, $pitanje_id, $odgovor)
    {
        $db = DB::getConnection();
        $st = $db->prepare('INSERT INTO p_answers (id_question, answer, id_user) VALUES (:pitanje_id, :answer, :user_id)');
        $st->execute(['pitanje_id' => $pitanje_id, 'answer' => $odgovor, 'user_id' => $user_id]);
    }

    static function addNewQuestion($question)
    {
        $db = DB::getConnection();
        $st = $db->prepare('INSERT INTO p_questions (question) VALUES (:question)');
        $st->execute(['question' => $question]);
    }
}
