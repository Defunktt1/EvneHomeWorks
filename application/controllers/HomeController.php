<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->view->show('portfolio_view.php', 'main_view.php');
    }
}