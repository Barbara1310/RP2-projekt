<?php

require __SITE_PATH . "/service/UserService.php";

class usersController extends BaseController
{
    // Funckija za prikaz profila trenutnog korisnika (Moj profil).
    public function index()
    {
        $user = $_SESSION["user"];
        $this->registry->template->user = $user;
        $this->registry->template->show("profile");
    }
}
