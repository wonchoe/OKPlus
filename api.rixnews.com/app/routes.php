<?php

class Router {

    private $called = false;
    public $routes;

    public function __construct() {
        $this->routes = require_once ROOT . 'config/routes_table.php';
    }

    private function getURI() {
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI') ? filter_input(INPUT_SERVER, 'REQUEST_URI') : '';
        if (!empty($uri)) {
            return trim($uri, '/');
        }
        return '/';
    }

    public function run() {

        foreach ($this->routes as $pattern => $value) {
            if (preg_match('~' . $pattern . '~', $this->getURI())) {
                $params = explode('/', preg_replace('~' . $pattern . '~', $value, $this->getURI()));
                $controllerName = ucfirst(array_shift($params)) . 'Controller';
                $controllerAction = array_shift($params);
                $page = new $controllerName;
                if (method_exists($page, $controllerAction) && is_callable(array($page, $controllerAction))) {
                    call_user_func_array(array($page, $controllerAction), $params);
                    $this->called = true;
                    break;
                }
            }
        }
        if (!$this->called) {
            exit(json_encode(array('result' => false)));
        }
    }

}
