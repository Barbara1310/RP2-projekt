<?php

require __SITE_PATH . "/service/SpomenarService.php";

class spomenarController extends BaseController
{

    function index()
    {
        $pitanje_id = $_GET['pitanje'];
        $_SESSION['pitanje'] = SpomenarService::getPitanjeById($pitanje_id);

        if (isset($_SESSION['akcija'])) {
            if ($_SESSION['akcija'] == 'my_answers') {
                $_SESSION['odgovori'] = SpomenarService::getOdgovorByUserId($_SESSION['user']->id, $pitanje_id);
            } else if ($_SESSION['akcija'] == 'read') {
                $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            } else if ($_SESSION['akcija'] == 'popuni') {

                if (isset($_POST['odgovor'])) {
                    $odgovor = $_POST['odgovor'];
                    if (preg_match('/^[-a-z0-9_ \x{100}-\x{17f} .,?!\:\(\*\)\=\+]+$/ui', $odgovor)) {
                        SpomenarService::setOdgovorByUserId($_SESSION['user']->id, $pitanje_id, $odgovor);
                        $_SESSION['user']->setPopunjeno($pitanje_id - 1);
                    } else {
                        $this->registry->template->error = true;
                        $this->registry->template->errorMessage = "Unos sadrži nedopušteni znak!";
                    }
                }


                $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            }
        } else {
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
        }
        $this->registry->template->show('pitanje');
    }

    function read()
    {
        $_SESSION['akcija'] = 'read';
        $this->registry->template->show("readSpomenar");
    }

    function fill()
    {
        $_SESSION['akcija'] = 'popuni';
        $pitanja = SpomenarService::getPitanjaAll();
        $odgovoreno = array();

        foreach ($pitanja as $pitanje) {

            $odgovoreno[] = (empty(SpomenarService::getOdgovorByUserId($_SESSION['user']->id, $pitanje->id)) == false);
        }
        $_SESSION['user']->odgovoreno = $odgovoreno;
        $this->registry->template->show("readSpomenar");
    }

    function my_answers()
    {
        $_SESSION['akcija'] = 'my_answers';
        $this->registry->template->show("readSpomenar");
    }
}
