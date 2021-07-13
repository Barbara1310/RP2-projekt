<?php

require __SITE_PATH . "/service/SpomenarService.php";

class spomenarController extends BaseController
{

    function index()
    {
        $pitanje_id = $_GET['pitanje'];
        $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);

        $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
        $this->registry->template->show('pitanje');
    }

    // Funkcija za pregled spomenara. Korisnik odavdje moze vidjeti sve prethone odgovore na pitanja,
    // pa tako i svoj ukoliko je spremljen. Iz ovog viewa se ne moze odogovriti na neodgovoreno pitanje.
    function read()
    {
        $_SESSION['akcija'] = 'read';
        if (!isset($_SESSION['pitanja'])) {
            $_SESSION['pitanja'] = SpomenarService::getPitanjaAll();
        }
        if (isset($_GET['pitanje'])) {
            // Vidi o kojem pitanju se radi, dohvati ga, te dogvati odgovore.
            $pitanje_id = $_GET['pitanje'];
            $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            $this->registry->template->show('pitanje');
        } else {
            // Prikazi linkove na sva pitanja prilikom prvog klika na 'Pogledaj spomenar'.
            $this->registry->template->show("readSpomenar");
        }
    }

    // Funckija za upisivanje u spomenar.
    // Ukoliko je user tek kliknuo na 'Upisi se u spomenar' prikazat ce se samo readSpomenar.php (linkovi na sva pitanja).
    // Klikom na link pitanja funckija gleda o kojem pitanju se radi, te dohvaca sve prethodne odgovore na to pitanje 
    // kako bi ih prikazala tretnutnom korisniku.
    //
    // Funckija takodjer obradjuje odgovor na pitanje koje se unosi kroz formu u pitanje.php.
    // Dopusteni znakovi za unos su engleska slova, brojevi, hrvatski znakovi čćšđž, te {., ,, ?, !, :, (, *, ), =, +}.
    // Ukoliko je odgovor ispravan on se sprema u bazu, inace se ispisuje greska.
    function fill()
    {
        // Spremi akciju kako bi se znalo u koju funckiju moramo uci nakon klika na link pitanja.
        $_SESSION['akcija'] = 'fill';
        if (isset($_GET['pitanje'])) {
            // Vidi o kojem pitanju se radi, te ga dohvati iz baze.
            $pitanje_id = $_GET['pitanje'];
            $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);
            if (isset($_POST['odgovor'])) {
                // Ako je user spremio odgovor, provjeri ga te ga spremi u bazu ako je ok.
                $odgovor = $_POST['odgovor'];
                if (preg_match('/^[-a-z0-9_ \x{100}-\x{17f} .,?!\:\(\*\)\=\+]+$/ui', $odgovor)) {
                    SpomenarService::setOdgovorByUserId($_SESSION['user']->id, $pitanje_id, $odgovor);
                    $_SESSION['user']->setPopunjeno($pitanje_id - 1);
                } else {
                    // Inace ispisi gresku.
                    $this->registry->template->error = true;
                    $this->registry->template->errorMessage = "Unos sadrži nedopušteni znak!";
                }
            }
            // Dohvati sve perthodne odgovore kako bi se mogli prikazati.
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            $this->registry->template->show('pitanje');
        } else {
            // Ako je user tek kliknuo na 'Upisi se u spomenar' dohvati sva pitanja, te provjeri je li trenutno user
            // odgovorio na njih. Informaciju spremi u polje odgovoreno koje se nalazi u klasi User.
            if (!isset($_SESSION['pitanja'])) {
                // Dohvati sva pitanja ako ih nemamo
                $_SESSION['pitanja'] = SpomenarService::getPitanjaAll();
            }
            $odgovoreno = array();

            foreach ($_SESSION['pitanja'] as $pitanje) {
                // DOhvatio informaciju je li odogovreno ili ne
                $odgovoreno[] = (empty(SpomenarService::getOdgovorByUserId($_SESSION['user']->id, $pitanje->id)) == false);
            }
            // Spremi informaciju u klasu User.
            $_SESSION['user']->odgovoreno = $odgovoreno;
            $this->registry->template->show("readSpomenar");
        }
    }

    // Funckija koja sluzi za prikaz odgovora od trenutnog usera.
    // Ukoliko je user kliknuo na pitanje prikazat ce se odgovor na to pitanje ukoliko postoji.
    // Ukoliko je user tek kliknuo na 'Moji odgovori' prikazat ce se samo readSpomenar.php (linkovi na sva pitanja).
    function my_answers()
    {
        // Spremi akciju kako bi se znalo u koju funckiju moramo uci nakon klika na link pitanja.
        $_SESSION['akcija'] = 'my_answers';
        if (!isset($_SESSION['pitanja'])) {
            $_SESSION['pitanja'] = SpomenarService::getPitanjaAll();
        }
        if (isset($_GET['pitanje'])) {
            // Vidi o kojem pitanju se radi
            $pitanje_id = $_GET['pitanje'];
            // Dohvati pitanje
            $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);
            // Dohvati odgovor na pitanje za tretnutnog usera.
            $_SESSION['odgovori'] = SpomenarService::getOdgovorByUserId($_SESSION['user']->id, $pitanje_id);
            $this->registry->template->show('pitanje');
        } else {
            // Prikazi linkove na sva pitanja
            $this->registry->template->show("readSpomenar");
        }
    }

    // Funckija za prikaz viewa za dodavanje novog pitanja (vidljivo samo adminu). Ukoliko korisnik unese novo pitanje,
    // ova funckija obradjue unos.
    // Dopusteni znakovi za unos su engleska slova, brojevi, hrvatski znakovi čćšđž, te {., ,, ?, !, :, (, *, ), =, +}.
    // Ukoliko je unos dobra, funckija sprema odgovor u bazu, a ako nije dobar ispisuje gresku useru.
    function add_question()
    {
        if (isset($_POST['question'])) {
            $q = $_POST['question'];
            if (preg_match('/^[-a-z0-9_ \x{100}-\x{17f} .,?!\:\(\*\)\=\+]+$/ui', $q)) {
                SpomenarService::addNewQuestion($q);
                unset($_SESSION['pitanja']); // resetiraj pitanja iz sessiona kako bi pokupili novu informaciju
            } else {
                $this->registry->template->error = true;
                $this->registry->template->errorMessage = "Unos sadrži nedopušteni znak!";
            }
        }
        $this->registry->template->show("addQuestion");
    }
}
