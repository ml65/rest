<?php

declare(strict_types=1);

/**
  Базовый класс объекта данных
 */

namespace Mls65\Bulletin\Entity;

class ProviderEntity 
{

    /*
     * @var string 
     */
    public $type;

    /*
     * @var string 
     */
    public $name;

    /*
     * @var float  
     */
    public $surname;

    /*
     * @var string
     */
    public $pathronymic;

    /*
     * @var array
     */
    private $error_validate;

    public function __construct($param = null) 
    {
        if($param) {
            $this->init($param);
            $this->validate();
        }
        return $this;
    }

    public function get_error() {
       return $this->error_validate;
    }
    
    public function init($param = null, $validate = true)
    {
        if($param) {
          if(array_key_exists("type", $param) && $param['type'] === 'individual') {
            $this->type          = $param['type'] ?? 'individual';
            $this->name        = $param['name'] ?? '';
            $this->surname     = $param['surname'] ?? '';
            $this->pathronymic = $param['pathronymic'] ?? '';
          } else {
            $this->type          = $param['type'] ?? 'entity';
            $this->name        = $param['name'] ?? '';
            $this->surname     = '';
            $this->pathronymic = '';
          }
          if($validate) $this->validate();
        } 
        
        return $this;
    }

    private function validate() {
        if($this->type === "individual") {
            if($this->name === '') $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Provider individual name is empty.');
            if($this->surname === '') $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Provider individual surname is empty.');
        } else {
            if($this->name === '') $this->error_validate = array( "code" => 1, "type" => "Error", "message" => 'Provider entity name is empty.');
        }
    }

}

