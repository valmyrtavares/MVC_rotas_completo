<?php
 require  __DIR__. '/vendor/autoload.php';

 use \App\Controller\Pages\Sobre;

 
 use \App\Controller\Pages\Home;
 use \App\Http\Router;
 use \App\Http\Response;
 use \App\Utils\View;



 define('URL', 'http://localhost/mvc-pratico');

 View::init([
    'URL' => URL
 ]);
 
 $obRouter = new Router(URL);


 $obRouter->get('/', [
    function(){
    return  new Response(200, Home::getHome());
    }
]);

$obRouter->get('/sobre', [
    function(){
    return  new Response(200, Sobre::getSobre());
    }
]);
// echo '<pre>';
// print_r($obRouter);
// exit;
 $obRouter->run()->sendResponse();


//  echo Home::getHome();