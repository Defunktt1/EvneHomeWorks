<?php


class MainController extends Controller
{
    public function index()
    {
        $this->view->show('main_view.php');
    }
}