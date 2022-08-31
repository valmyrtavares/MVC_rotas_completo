<?php
namespace App\Controller\Pages;
use \App\Utils\View;

class Page{
    private static function getHeader()
    {
        return View::render('page/Header',[
            URL=> 'http://localhost/mvc-pratico'
        ]);
    }
 
    private static function getFooter()
    {
        return View::render('page/Footer');
    }

    public static function getPage($title, $content)
    {
        return  View::render('page/Page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()

        ]);

    }
}