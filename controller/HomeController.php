<?php

class homeController extends BaseController
{
    // Prikazi landing page
    function index()
    {
        $user = $_SESSION["user"];
        $this->registry->template->show("home");
    }
}
