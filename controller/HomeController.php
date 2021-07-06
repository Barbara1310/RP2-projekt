<?php

class homeController extends BaseController
{
    function index()
    {
        $user = $_SESSION["user"];
        $this->registry->template->show("home");
    }
}
