<?php

class View
{
    function show($contextView, $masterView = null, $data = null)
    {
        if ($masterView == null) {
            include 'application/views/' . $contextView;
        } else {
            include 'application/views/' . $masterView;
        }
    }
}