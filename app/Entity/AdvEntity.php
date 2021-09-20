<?php

declare(strict_types=1);

/**
  Базовый класс объекта данных
 */

namespace Mls65\Bulletin\Entity;

use Mls65\Bulletin\Entity\ProviderEntity;

class AdvEntity 
{

    /*
     * @var string 
     */
    public $id = '';

    /*
     * @var string 
     */
    public $name = '';

    /*
     * @var float  
     */
    public $price = 0;

    /*
     * @var ProviderEntity
     */
    public $provider;

    /*
     * @var string 
     */
    public $description = '';

    /*
     * @var string 
     */
    public $mainimage = '';

    /*
     * @var array 
     */
    public $images = array();

    /*
     * @var string 
     */
    public $datetime = '';

    /*
     * @var string 
     */
    private $error_validate = '';

    public function __construct($param = null, $validate = true ) 
    {
        if($param) {
            $this->init($param, $validate);
            if($validate) $this->validate();
        }
        return $this;
    }
    
    public function init($param, $validate = true)
    {
        $this->id          = $param['id'] ?? 0;
        $this->name        = $param['name'] ?? '';
        $this->price       = $param['price'] ?? 0;
        if(array_key_exists('provider',$param) && $param['provider']) {
            $this->provider = new ProviderEntity($param['provider'], $validate);
        }/* else {
            $this->provider = new PrividerEntity();
        }*/
        $this->description = $param['description'] ?? '';
        $this->mainimage   = $param['mainimage'] ?? '';
        $this->images      = $param['images'] ?? array();
        $this->datetime    = $param['datetime'] ?? '';

        return $this;
    }

    public function get_error() {
        return $this->error_validate;
    }

    private function validate() {
        if(!property_exists($this,"name") || $this->name == '') {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Not have name.' );
        }
        if(!property_exists($this,"mainimage") || $this->mainimage == '') {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Not have images.' );
        }
        if(!is_array($this->images)) {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Not have images.' );
        }
        if( count($this->images) < 1) {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Not have images.' );
        }
        if( count($this->images) > 2) {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Too many images.' );
        }
        if( strlen($this->description) > 1000) {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Description is very long.' );
        }
        if( strlen($this->name) > 200) {
            $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Name is very long.' );
        }
        if($this->provider->error_validate) {
           $this->error_validate = $this->provider->get_error();
        }

    }

}

