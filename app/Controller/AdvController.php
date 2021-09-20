<?php

namespace Mls65\Bulletin\Controller;

use Mls65\Bulletin\Engine\Storage;
use Mls65\Bulletin\Entity\AdvEntity;
use Carbon\Carbon;

class AdvController {

    /**
     * @var Request
     */
    private $request;
    private $response;
    private $entity;
    private $adv;
    private $advrepo;
    private $templ;
    
    public function __construct()
    {
// объект работы с запросом
        $this->request = Storage::get('Request');
// объект данных
        $this->entity = Storage::get('Entity');   
// репозиторий
        $this->advrepo = Storage::get('Repository');   
// объект работы с запросом
        $this->response = Storage::get('Response');
// объект шаблонизатора
        $this->templ = Storage::get('Template');
// объект маршрутизатор
        $this->router = Storage::get('Router');

    }

    public function getAdvList()
    {
        $advlist = $this->advrepo->getAdvList($this->request->params);
        return $this->response->prepare($advlist);
    }

    public function getAdv()
    {
        $param = $this->router->getparam();
        $id = $param[1];
        $adv = $this->advrepo->getAdv($id,$this->request->params);
        return $this->response->prepare($adv);
    }

    public function saveAdv()
    {
            $adv = new AdvEntity($this->request->json);
            if($adv->get_error()) {
                return $this->response->prepare($adv->get_error());
            }
            return $this->response->prepare($this->advrepo->saveAdv($adv));
    }



    public function error404()
    {
        echo "<h1>Test backend</h1><h2>ERROR 404!</h2>Current commands: <br>GET /adv<br>POST /adv<br>GET /adv/&lt;number&gt;"; exit;
    }

}