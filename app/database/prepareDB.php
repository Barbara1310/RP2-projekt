<?php
// Manualno inicijaliziramo bazu ako već nije.
require_once './db.class.php';

$db = DB::getConnection();

$has_tables = false;

try {
    $st = $db->prepare(
        'SHOW TABLES LIKE :tblname'
    );

    $st->execute(array('tblname' => 'p_users'));
    if ($st->rowCount() > 0)
        $has_tables = true;

    $st->execute(array('tblname' => 'p_questions'));
    if ($st->rowCount() > 0)
        $has_tables = true;
} catch (PDOException $e) {
    exit("PDO error [show tables]: " . $e->getMessage());
}

if ($has_tables) {
    exit('Tablice p_users / p_questions / p_answers već postoje. Obrišite ih pa probajte ponovno.');
}

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS p_users (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'username varchar(50) NOT NULL,' .
            'password_hash varchar(255) NOT NULL,' .
            'email varchar(50) NOT NULL,' .
            'has_registered int,' .
            'registration_sequence varchar(20) NOT NULL,' .
            'is_admin tinyint)'
    );

    $st->execute();
} catch (PDOException $e) {
    exit("PDO error [create p_users]: " . $e->getMessage());
}

echo "Napravio tablicu p_users.<br />";

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS p_questions (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'question varchar(100) NOT NULL)'
    );

    $st->execute();
} catch (PDOException $e) {
    exit("PDO error [create p_questions]: " . $e->getMessage());
}

echo "Napravio tablicu p_questions.<br />";

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS p_answers (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_question int NOT NULL,' .
            'answer varchar(100),' .
            'id_user int NOT NULL)'
    );

    $st->execute();
} catch (PDOException $e) {
    exit("PDO error [create p_answers]: " . $e->getMessage());
}

echo "Napravio tablicu p_answers.<br />";

// Ubaci neke korisnike unutra
try {
    $st = $db->prepare('INSERT INTO p_users(username, password_hash, email, has_registered, registration_sequence, is_admin) VALUES (:username, :password, \'a@b.com\', \'1\', \'abc\', \'1\')');

    $st->execute(array('username' => 'andjela', 'password' => password_hash('andjela', PASSWORD_DEFAULT)));
    $st->execute(array('username' => 'martina', 'password' => password_hash('martina', PASSWORD_DEFAULT)));
    $st->execute(array('username' => 'barbara', 'password' => password_hash('barbara', PASSWORD_DEFAULT)));
} catch (PDOException $e) {
    exit("PDO error [insert p_users]: " . $e->getMessage());
}

echo "Ubacio u tablicu p_users.<br />";

// Ubaci neka pitanja unutra
try {
    $st = $db->prepare('INSERT INTO p_questions(question) VALUES (:question)');

    $st->execute(array('question' => 'Kako se zoveš?'));
    $st->execute(array('question' => 'Koji ti je nadimak?'));
    $st->execute(array('question' => 'Koja ti je najdraža boja?'));
    $st->execute(array('question' => 'Imaš li simpatiju?'));
    $st->execute(array('question' => 'Koji je tvoj hobi?'));
    $st->execute(array('question' => 'Koja ti je najdraža pjesma?'));
} catch (PDOException $e) {
    exit("PDO error [insert p_questions]: " . $e->getMessage());
}

echo "Ubacio u tablicu p_questions.<br />";

// Ubaci neke odgovore unutra
try {
    $st = $db->prepare('INSERT INTO p_answers(id_question, answer, id_user) VALUES (:id_question, :answer, :id_user)');

    $st->execute(array('id_question' => 1, 'answer' => 'Andjela', 'id_user' => 1));
    $st->execute(array('id_question' => 2, 'answer' => 'Nemam', 'id_user' => 1));
    $st->execute(array('id_question' => 3, 'answer' => 'Plava', 'id_user' => 1));
    $st->execute(array('id_question' => 4, 'answer' => 'Da', 'id_user' => 1));
    $st->execute(array('id_question' => 5, 'answer' => 'Plivanje', 'id_user' => 1));
    $st->execute(array('id_question' => 6, 'answer' => 'Shallow', 'id_user' => 1));

    $st->execute(array('id_question' => 1, 'answer' => 'Martina', 'id_user' => 2));
    $st->execute(array('id_question' => 2, 'answer' => 'Nemam', 'id_user' => 2));
    $st->execute(array('id_question' => 3, 'answer' => 'Narančasta', 'id_user' => 2));
    $st->execute(array('id_question' => 4, 'answer' => 'Da', 'id_user' => 2));
    $st->execute(array('id_question' => 5, 'answer' => 'Plivanje', 'id_user' => 2));
    $st->execute(array('id_question' => 6, 'answer' => 'Leave the Door Open', 'id_user' => 2));

    $st->execute(array('id_question' => 1, 'answer' => 'Barbara', 'id_user' => 3));
    $st->execute(array('id_question' => 2, 'answer' => 'Nemam', 'id_user' => 3));
    $st->execute(array('id_question' => 3, 'answer' => 'Lila', 'id_user' => 3));
    $st->execute(array('id_question' => 4, 'answer' => 'Da', 'id_user' => 3));
    $st->execute(array('id_question' => 5, 'answer' => 'Plivanje', 'id_user' => 3));
    $st->execute(array('id_question' => 6, 'answer' => 'Cesarica od Olivera :)', 'id_user' => 3));
} catch (PDOException $e) {
    exit("PDO error [insert p_answers]: " . $e->getMessage());
}

echo "Ubacio u tablicu p_questions.<br />";
