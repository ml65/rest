<?php

/*
 * Роутер приложения
 */

use Mls65\Bulletin\Engine\Storage;
 
try {

    $router = Storage::get('Router');
    $router->get( '/404','AdvController@error404');
    $router->get( '/adv','AdvController@getAdvList');
    $router->post('/adv','AdvController@saveAdv');
    $router->get( '/adv/(.+)','AdvController@getAdv');
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}