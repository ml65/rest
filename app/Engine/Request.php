<?php

namespace Mls65\Bulletin\Engine;

class Request {

    /**
     * @var string get, post etc
     */
    public $request_method;

    /**
     * @var string current url
     */
    public $uri;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string get params
     */
    public $params;

    /**
     * @var string
     */
    public $method;
    
    /**
     * @var string post params
     */
    public $post;

    /**
     * @var string 
     */
    public $body;

    /**
     * @var array
     */
    public $json;
    
    public function __construct()
    {
        $this->request_method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $parameters = parse_url($this->uri);
        $query = array();
        if (isset($parameters["query"])) 
            parse_str($parameters["query"], $query);
        $this->uri = $parameters['path'];
        $this->params = $query;
        $this->post = $_POST;
        $this->body = file_get_contents('php://input');
        $json = json_decode($this->body, true);
        if($json) $this->json = $json;

    }
    
    public function getIntParam($name)
    {
        if (!empty($this->params[$name])) {
            return (int) $this->params[$name];
        } else {
            throw new \Exception('Params '.$name.' not found');
        }
    }

    public function setRoute($route)
    {
        $route = explode('@', $route);
        if (empty($route[0])) {
            throw new \Exception('Not found controller');
        }
        $this->controller = 'Mls65\\Bulletin\\Controller\\'.$route[0];
        if (empty($route[1])) {
            throw new \Exception('Not found method controller');
        }
        $this->method = $route[1];
    }
}
