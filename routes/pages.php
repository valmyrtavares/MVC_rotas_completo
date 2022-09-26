<?php
use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/', [
    function(){
    return  new Response(200, Pages\Home::getHome());
    }
]);

$obRouter->get('/sobre', [
    function(){
    return  new Response(200, Pages\Sobre::getSobre());
    }
]);

$obRouter->get('/depoimento', [
    function(){
    return  new Response(200, Pages\Depoimentos::getDepoimentos());
    }
]);

$obRouter->post('/depoimento', [
    function($request){   
    return  new Response(200, Pages\Depoimentos::insertDepoimentos($request));
    }
]);