<?php

use application\models\Search;
include 'application\models\Search.php';

class TextController extends Controller
{
    public function index()
    {
        $searches = new Search();
        $searches->insert('test');
        $this->view->show('php_view.php');
    }

    public function get()
    {
        $searches = new Search();
        var_dump(json_encode($searches->all()));
    }
}