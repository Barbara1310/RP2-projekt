<?php

require_once(__SITE_PATH . "/service/UserService.php");

class loginController extends BaseController
{
    // Ovo je defaultna funkcija koja se poziva prilikom pokretanja web aplikacije.
    // Ukoliko smo vec ulogirani prikazuje nam pocetnu stranicu home/index.
    // U suportnom ispisuje formu za login/registraciju.
    function index()
    {
        if (!isset($_SESSION["user"])) {
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        } else {
            header('Location: ' . __SITE_URL . '/index.php?rt=home/index');
        }
    }

    // Funckija za obradu logina/registracije.
    function processLoginForm()
    {
        if (isset($_POST["register"])) $this->processRegister();
        if (isset($_POST["login"])) $this->processLogin();
    }

    // Funckija za obradu logina.
    // Dohvaca uneseni username/password. Dohvaca usera iz baza po kljucu username.
    // Ukoliko takav user ne postoji ispisuje poruku da su username ili password netocni, te
    // ponovo prikazuje login / register formu.
    //
    // Ukoliko user postoji, provjerava se password. Ukoliko je password netocan ispisuje se poruka
    // a su username ili password netocni, te ponovo prikazuje login / register formu.
    //
    // Ukoliko je password tocan, ali nije zavrsena registracija, ispisuje se poruka da se registacija
    // mora obaviti do kraja.
    //
    // Inace se korisnik uspjesno ulogirava te mu se prikazuje home/index.
    function processLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = UserService::getUserByUsername($username);
        if (!$user) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Wrong username or password!";
            $this->registry->template->show("login");
            return;
        }
        if (!password_verify($password, $user->password_hash)) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Wrong username or password!";
            $this->registry->template->show("login");
        } elseif (!$user->has_registered) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "You have to finish the registration first!";
            $this->registry->template->show("login");
        } else {
            $_SESSION["user"] = $user;
            header('Location: ' . __SITE_URL . '/index.php?rt=home/index');
        }
    }

    // Obrada logouta. Ubija se session te se prikazuje login/registration forma.
    function processLogout()
    {
        session_destroy();
        header('Location: ' . __SITE_URL . '/index.php?');
    }

    // Funckija za obradu registracije.
    // Provjerava se ispravnost emaila. Provjerava se jesu li uneseni user/passwd/email. Ako nisu ispisuje se poruka da
    // se moraju popuniti sva polja.
    //
    // Ukoliko su polja popunjena provjera se postoji li takav username vec. Ako da ispisuje se poruka da vec postoji
    // isti username te se ponovo prikazuje login / registration forma.
    //
    // Inace se podaci o useru spremaju u klasu u User, te se user upisuje u bazu. Priprema se te se salje registracijski mail.
    function processRegister()
    {
        $email = $_POST["email"] ?? null;
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $username = $_POST["username"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email || !$username || !$password) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Enter all the fields!";
            $this->registry->template->show("login");
        } else {
            $user = UserService::getUserByUsername($username);
            if (isset($user->username)) {
                $this->registry->template->error = true;
                $this->registry->template->errorMessage = "Username already exists!";
                $this->registry->template->show("login");
            } else {
                // pripremi user podatke
                $user->username = $username;
                $user->email = $email;
                $user->password_hash = password_hash($password, PASSWORD_DEFAULT);
                $user->is_admin = 0;
                $link = '<a href = "http://' . $_SERVER["HTTP_HOST"] . __SITE_URL . "/index.php?rt=login/finishRegistration&sequence=";
                $sequence = "";

                for ($i = 0; $i < random_int(10, 20); $i++) $sequence .= chr(random_int(97, 122));
                $link .= $sequence . '">link</a>';
                $user->registration_sequence = $sequence;
                // Spremi usera u bazu
                UserService::saveUser($user);

                // Pripremi mail
                $subject = "Registration for e-spomenar";
                $body = "Click on the followinng " . $link . " to finish your registration for e-spomenar!";
                $headers = "Content-type: text/html\r\n";
                $headers .= "To: " . $email . "\r\n";
                $headers .= 'From: e-spomenar <e@spomenar.com>' . "\r\n";
                // salji mail
                if (mail($email, $subject, $body, $headers)) {
                    echo "Check your mail to finish a registration :)";
                    return;
                } else echo "Something's wrong: "; //. var_dump(error_get_last());
            }
        }
    }

    // Funckija za obradu kraja registracije.
    // has_registered se stavlja u true te se updatea user u bazi.
    function finishRegistration()
    {
        $sequence = $_GET["sequence"] ?? null;
        echo $sequence;
        $user = UserService::getUserByRegSeq($sequence);
        if (!$user) {
            echo "Something's wrong: " . var_dump(error_get_last());
            return;
        }
        // stavi set_registered na true
        $user->has_registered = true;
        // Updateaj bazu
        UserService::updateUser($user);
        $_SESSION["user"] = $user;
        // prikazi home/indeks
        header('Location: ' . __SITE_URL . '/index.php');
    }
}
