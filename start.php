<?php

// Инициализация хранилища приложения

use Mls65\Bulletin\App;
use Mls65\Bulletin\Engine\Request;
use Mls65\Bulletin\Engine\Response;
use Mls65\Bulletin\Engine\Router;
use Mls65\Bulletin\Engine\Storage;
use Mls65\Bulletin\Engine\Template;
use Mls65\Bulletin\Entity\AdvEntity;
use Mls65\Bulletin\Repository\AdvRepository;

Storage::set('Request',  new Request());
Storage::set('Response', new Response());
Storage::set('Router',   new Router());
Storage::set('Response', new Response());
Storage::set('Repository', new AdvRepository());
Storage::set('Template', new Template());
Storage::set('Entity',   new AdvEntity());
Storage::set('App',      new App());
