<?php

namespace Mls65\Bulletin\Engine;

class Router {

    /**
     * @var Request
     */
    private $request;

    /**
     * @var array request map
     */
    private $map = [];
    
    /**
     * @var array param
     */
    private $param;      // параметры из URI

    public function __construct()
    {
        $this->request = Storage::get('Request');
    }


    public function get($path, $params)
    {
        $this->map['GET'][$path] = $params;
    }

    public function post($path, $params)
    {
        $this->map['POST'][$path] = $params;
    }

    public function getCurrent()
    {
        if (empty($this->map[$this->request->request_method])) {
            throw new \Exception('Not found method');
        }

        $current_map = $this->map[$this->request->request_method];

        if (empty($current_map[$this->request->uri])) {
        // Отрабатываем параметры
            $current_route = '';
            foreach($current_map as $pat=>$route) {
                 $pat = '/'.str_replace("/",'\/', $pat).'/';
                 if(preg_match($pat,$this->request->uri, $match)) {
                     $current_route = $route;
                     $this->param = $match;
                 }
            }
            if(! $current_route) {
                $current_route = $current_map['/404'];
            }
        } else {
            $current_route = $current_map[$this->request->uri];
        }
        $this->request->setRoute($current_route);
        return $this->request;
    }

    public function getParam() {
    
        return $this->param;

    }

}
