<?php 

declare(strict_types=1);


/**
  Интерфейс репозитория
 */
 
namespace Mls65\Bulletin\Interfaces;

use Mls65\Bulletin\Entity\AdvEntity;

interface AdvRepositoryInterface
{
     public function getAdvList($params);

     public function getAdv(int $id, $params);

     public function saveAdv(AdvEntity $adv);
}