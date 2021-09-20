<?php


use PHPUnit\Framework\TestCase;

class AdvEntityTest extends TestCase
{

  private $adv;


   protected function setUp() : void {
       $this->adv = new Mls65\Bulletin\Entity\AdvEntity();
   }

   protected function tearDown() : void {
   
   }
   
   /*
    *
    */
   
   public function testInit1() {
       $params = array(
           "name" => "1111111111111",
           "price" => 12.0,
           "desciption" => "",
           "mainimage" => "file1.jpg",
           "images" => array( "file2.jpg", "file3.jpg"),
           "provider" => array ( "type" => "individual", "name" => "Name", "surname" => "Surname", "pathronymic" => "Pathroymic" ),
       );
       $this->adv->init($params);
      
   }



}
