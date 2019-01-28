<?php

class Controller
{
    public $view;
    public $model;

    function __construct()
    {
        $this->view = new View();
    }

    function get404()
    {
        $this->view->show('templates/view_404.php');
    }
}