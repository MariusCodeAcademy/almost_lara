<?php
require_once '../vendor/autoload.php';

use app\core\Application;


$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');

$app->router->get('/about', 'about');

$app->router->get('/contact', 'contact');
// we create post path
$app->router->post('/contact', function () {
    return "Handing contact form Post request";
});

$app->run();