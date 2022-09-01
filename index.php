<?php
 require  __DIR__. '/vendor/autoload.php';

 //use \App\Controller\Pages\Sobre;
 //use \App\Controller\Pages\Home;
 use \App\Http\Router;
 // use \App\Http\Response;
 use \App\Utils\View;



 define('URL', 'http://localhost/mvc-pratico');

 View::init([
    'URL' => URL
 ]);
 
 $obRouter = new Router(URL);

include __DIR__. '/routes/pages.php';

// echo '<pre>';
// print_r($obRouter);
// exit;
 $obRouter->run()->sendResponse();


//  echo Home::getHome();