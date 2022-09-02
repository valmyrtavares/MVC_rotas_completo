<?php

namespace App\Controller\Pages;
use  \App\Utils\View;

class Depoimentos extends Page
{
    public static function getDepoimentos(){

        
        $content = View::render("page/depoimentos",[
         

        ]);
        return parent::getPage('Depoimentos', $content);

    }
}