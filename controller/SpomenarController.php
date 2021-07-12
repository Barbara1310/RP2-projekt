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

    function read()
    {
        $_SESSION['akcija'] = 'read';
        if (!isset($_SESSION['pitanja'])) {
            $_SESSION['pitanja'] = SpomenarService::getPitanjaAll();
        }
        if (isset($_GET['pitanje'])) {
            $pitanje_id = $_GET['pitanje'];
            $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            $this->registry->template->show('pitanje');
        } else {
            $this->registry->template->show("readSpomenar");
        }
    }

    function fill()
    {
        $_SESSION['akcija'] = 'fill';
        if (isset($_GET['pitanje'])) {
            $pitanje_id = $_GET['pitanje'];
            $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);
            if (isset($_POST['odgovor'])) {
                $odgovor = $_POST['odgovor'];
                echo $odgovor . '<br>';
                if (preg_match('/^[-a-z0-9_ \x{100}-\x{17f} .,?!\:\(\*\)\=\+]+$/ui', $odgovor)) {
                    SpomenarService::setOdgovorByUserId($_SESSION['user']->id, $pitanje_id, $odgovor);
                    $_SESSION['user']->setPopunjeno($pitanje_id - 1);
                    echo 'tututu';
                } else {
                    $this->registry->template->error = true;
                    $this->registry->template->errorMessage = "Unos sadrži nedopušteni znak!";
                }
            }
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            $this->registry->template->show('pitanje');
        } else {

            if (!isset($_SESSION['pitanja'])) {
                $_SESSION['pitanja'] = SpomenarService::getPitanjaAll();
            }
            $odgovoreno = array();

            foreach ($_SESSION['pitanja'] as $pitanje) {

                $odgovoreno[] = (empty(SpomenarService::getOdgovorByUserId($_SESSION['user']->id, $pitanje->id)) == false);
            }
            $_SESSION['user']->odgovoreno = $odgovoreno;
            $this->registry->template->show("readSpomenar");
        }
    }

    function my_answers()
    {
        $_SESSION['akcija'] = 'my_answers';
        if (!isset($_SESSION['pitanja'])) {
            $_SESSION['pitanja'] = SpomenarService::getPitanjaAll();
        }
        if (isset($_GET['pitanje'])) {
            $pitanje_id = $_GET['pitanje'];
            $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);
            $_SESSION['odgovori'] = SpomenarService::getOdgovorByUserId($_SESSION['user']->id, $pitanje_id);
            $this->registry->template->show('pitanje');
        } else {
            $this->registry->template->show("readSpomenar");
        }
    }

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
