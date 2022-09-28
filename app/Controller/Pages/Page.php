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

    //Metodo responsábel de renderizar o layout de paginação
    public static function getPagination($request, $obPagination){
        //PAGINAS
        $pages = $obPagination->getPages();
        //VERIFICA A QUANTIDADE DE PAGINAS
        if(count($pages) <= 1) return '';

        //LINKS
        $links ='';

        //ULR atual sem os gets 
        $url = $request->getRouter()->getCurrentUrl(); 

        //GET
        $queryParams = $request->getQueryParams();

         //RENDERIZA OS LINKS
        foreach($pages as $page){
            //ALTERA PÁGINA
            $queryParams['page'] = $page['page'];
             //link
             $link = $url. '?' .http_build_query($queryParams);

           //VIEW
           $links .= View::render('page/pagination/link',[
            'page' => $page['page'],
            'link' => $link,
            'active' => $page['current'] ? 'active' : ''
           ]);
        }
        return $link .= View::render('page/pagination/box',[
            'links' => $links
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