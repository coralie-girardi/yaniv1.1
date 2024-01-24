<?php
// ----- NAMESPACE -----
namespace Controllers;

class Error404Controller
{

    public function Display404()
    {
        $template = 'page404.phtml';
        include_once 'views/layout.phtml';

    }

}