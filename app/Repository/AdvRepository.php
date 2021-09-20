<?php
/*
 * Получаем данные из БД
 */



namespace Mls65\Bulletin\Repository;

use Mls65\Bulletin\Interfaces\AdvRepositoryInterface;
use Mls65\Bulletin\Entity\AdvEntity;

class AdvRepository  implements AdvRepositoryInterface {

    private $data;
    private $dbh;
    private $max = 10;
    private $request;
    private $sortaviable = array(
        "price"    => 1,
        "datetime" => 1,
    );
    private $fieldsaviable = array(
        "description" => 1,
        "images"      => 1,
        "provider"    => 1,
    );


    public function __construct()
    {
        $host = $_SERVER["MYSQLHOST"] ?? '';
        $dbname = $_SERVER["MYSQLBASE"] ?? '';
        $user = $_SERVER["MYSQLUSER"] ?? '';
        $pass = $_SERVER["MYSQLPASSWORD"] ?? '';
        $optPDO = array(
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );

        $this->dbh = new \PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass,$optPDO);
    }

    public function getAdvList($params)
    {
        $page = $params["page"] ?? 0;
        $sort = $params["sort"] ?? '';

        $query = "SELECT COUNT(*) ccc FROM `adv` ";
        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $row = $sth->fetch();
        $countpages = ceil($row["ccc"]/$this->max);

        if(!$page || $page <0 ) $page = 0;
        $limit = ' LIMIT '.($page*$this->max).",".$this->max;
        $order = '';
        if($sort) {
            if(preg_match('/^(.+):(.+)/',$sort,$match)) {
               $sort = $match[1];
               $dir  = '';
               if(mb_strtolower($match[2]) === 'desc') $dir = 'DESC'; 
            } else { $dir = ''; }
            if(array_key_exists($sort, $this->sortaviable)) {
              $order = "ORDER BY `".$sort."` ".$dir;
            }
        }
        $query = "SELECT * FROM `adv` ".$order.$limit;
        $sth = $this->dbh->prepare($query);
        $sth->execute();
        
        return array(
        "curentPage" => $page,
        "pageCount"  => $countpages,
        "items" => $this->conv2Advs($sth->fetchAll()),
        );
    }


    public function getAdv($id, $params) {

        $fields = "`id`, `name`, `price`, `mainimage`,`datetime`";
        if(is_array($params) && array_key_exists("fields", $params)) {
            $flds = explode(',',$params["fields"]);
            foreach($flds as $fld) {
                if(array_key_exists($fld, $this->fieldsaviable)) {
                    if(mb_strtolower($fld) === "provider") {
                        $fields .= ", `provider_type`";
                    } else {
                        $fields .= ",`".$fld."`";
                    }
                }
            } 
        }
    
        $query = "SELECT ".$fields." FROM `adv` WHERE id=:id";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(":id",$id);
        $sth->execute();
        return $this->conv2Adv($sth->fetch());

    }

    public function saveAdv(AdvEntity $adv) {
      try {
        $query = "INSERT INTO `adv` (
          `id`, 
          `name`, 
          `price`, 
          `provider_type`, 
          `provider_name`, 
          `provider_surname`, 
          `provider_pathronymic`, 
          `description`, 
          `mainimage`, 
          `images`, 
          `datetime`
         ) VALUES (
           NULL, 
           :name, 
           :price, 
           :provider_type, 
           :provider_name, 
           :provider_surname, 
           :provider_pathronymic,
           :description, 
           :mainimage, 
           :images,
           CURRENT_TIMESTAMP);";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(":name",$adv->name);
        $sth->bindParam(":price",$adv->price);
        $provider = $adv->provider;
        $sth->bindParam(":provider_type",$provider->type);
        $sth->bindParam(":provider_name",$provider->name);
        $sth->bindParam(":provider_surname",$provider->surname);
        $sth->bindParam(":provider_pathronymic",$provider->pathronimyc);
        $sth->bindParam(":description",$adv->description);
        $sth->bindParam(":mainimage",$adv->mainimage);
        $images = implode("\n",$adv->images);
        $sth->bindParam(":images",$images);
        $sth->execute();
        $id = $this->dbh->lastInsertId();
        $res = array(
           "id" => $id,
           "code" => 0,
           "type" => "insert",
           "message" => "success"
        );
        return $res;
      } catch (Exeption $e) {
        
      }

    }
    

    private function conv2Advs($rows) {

        $arr = array();
        foreach($rows as $row) {
            $arr[] = $this->conv2Adv($row);
        }
        return $arr;
    }

    private function conv2Adv($row) {

        $provider = array();
        if(array_key_exists("provider_type",$row)) {
            if($row["provider_type"] === "individual") {
                $provider = array(
                    "type"        => $row["provider_type"]        ?? '',
                    "name"        => $row["provider_name"]        ?? '',
                    "surname"     => $row["provider_surname"]     ?? '',
                    "pathronymic" => $row["provider_pathronymic"] ?? '',
                );
            } else { 
                $provider = array(
                    "type" => $row["provider_type"],
                    "name" => $row["provider_name"],
                );
            }
        }
        $row["provider"] = $provider;
        unset($row["provider_type"], 
            $row["provider_name"],
            $row["provider_surname"],
            $row["provider_pathronymic"],
        );
        if(array_key_exists("images", $row)) {
          $file = array();
          $files = preg_split('/\n|\r\n?/', $row["images"]);
//        explode("\r\n",$row["images"]);
          $row["images"] = $files;
        }
        return new AdvEntity($row, false);
    }

}
