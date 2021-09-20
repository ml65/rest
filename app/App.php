<?php

namespace Mls65\Bulletin;

use Mls65\Bulletin\Engine\Request;
use Mls65\Bulletin\Engine\Router;
use Mls65\Bulletin\Engine\Storage;

class App {

    /**
     * @var Router
     */
    private $router;

    public function __construct()
    {
        $this->router = Storage::get('Router');
    }

    public function run()
    {
        $current_request = $this->router->getCurrent();
        $controller = new $current_request->controller;
        $response = $controller->{$current_request->method}();
        $response->render();
    }
}
