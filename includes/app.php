<?php

require  __DIR__. '/../vendor/autoload.php';


use \App\Utils\View;
use \App\Common\Environment;
use  \App\Db\Database;

Environment::load(__DIR__. '/../');
define('URL',getenv('URL'));

// echo getenv('DB_HOST');
// echo getenv('DB_NAME');
// echo getenv('DB_USER');
// echo getenv('DB_PASS');
// exit;

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS')
);


View::init([
   'URL' => URL
]);