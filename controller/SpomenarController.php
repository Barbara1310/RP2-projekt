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
                unset($_SESSION['akcija']);
            } else if ($_SESSION['akcija'] == 'read') {
                $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
                unset($_SESSION['akcija']);
            } else if ($_SESSION['akcija'] == 'popuni') {
                $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
            }
        } else if (isset($_POST['odgovor'])) {
            $odgovor = $_POST['odgovor'];
            if (preg_match('/^[a-zA-Z0-9,-. ?!]+$/', $odgovor)) {
                SpomenarService::setOdgovorByUserId($_SESSION['user']->id, $pitanje_id, $odgovor);
            }
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
        } else {
            $_SESSION['odgovori'] = SpomenarService::getOdgovoriByPitanjeId($pitanje_id);
        }
        $this->registry->template->show('pitanje');
    }

    function read()
    {
        $_SESSION['akcija'] = 'my_answers';
        $this->registry->template->show("readSpomenar");
    }

    function fill()
    {
        $_SESSION['akcija'] = 'popuni';
        $this->registry->template->show("readSpomenar");
    }

    function my_answers()
    {
        $_SESSION['akcija'] = 'my_answers';
        $this->registry->template->show("readSpomenar");
    }
}
