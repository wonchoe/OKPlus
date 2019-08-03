<?php
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *.rixnews.com");
ini_set('display_errors', 'on');
error_reporting(E_ALL);

define('ROOT', substr(__DIR__,0,strrpos(__DIR__, '/')) . '/public_html/');
define('apiVersion','1.0');
define('SECRET_KEY', '');

require ROOT.'/lib/vendor/autoload.php';
require_once ROOT.'app/routes.php';

spl_autoload_register(function ($class) {
    if (file_exists('app/controllers/' . ucfirst($class) . '.php')) {
        require 'app/controllers/' . ucfirst($class) . '.php';
    } else if (file_exists('app/models/' . ucfirst($class) . '.php'))
        require 'app/models/' . ucfirst($class) . '.php';
});

$router = new Router();
$router->run();
