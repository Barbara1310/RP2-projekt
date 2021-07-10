<?php


class spomenarController extends BaseController
{

    function index()
    {
        $pitanje = 'pitanje' . $_GET['pitanje'];
        $this->registry->template->show($pitanje);
    }

    function read()
    {
        $this->registry->template->show("readSpomenar");
    }

    function fill()
    {
        $this->registry->template->show("readSpomenar");
    }

    function my_answers()
    {
        $this->registry->template->show("readSpomenar");
    }
}
