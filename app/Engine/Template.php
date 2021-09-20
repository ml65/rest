<?php

namespace Mls65\Bulletin\Engine;

class Template {

    /**
     * @var Request
     */
    private $templates;

    public function __construct()
    {
        $dir = __DIR__ ."/../../templ/";
        $list = glob($dir."*.html");
        foreach($list as $file) {
          $name = basename($file);
          $this->templates[$name] = file_get_contents($file);
        }
    }

    public function render($templ, $data)
    {
       if(array_key_exists($templ, $this->templates)) {
           $str = $this->templates[$templ];
           $this->parrams($str, $data, '');           

           $pat =  '|\{\$[a-zA-Z0-9]\}|sU';	// удаляем неопределенные переменные?
           $rep = '';
           $str = preg_replace($pat, $rep, $str);
           return $str;
       } else {
           return "ERROR! Cannot find template <b>".$templ."</b><br>";
       }
    }

    function parrams(&$str, $data, $level) {
       $curlevel = $level;

       foreach ($data as $key=>$val) {
           if(is_array($val)) {
               if($level) {
                   $newlevel = $level.":".$key;
               } else {
                   $newlevel = $key;
               }
               $this->parrams($str, $val, $newlevel);
           } else {
//echo "=key=",$curlevel," ",$key," = ",$val,"<br>";
               if($level) {
                   $pat = '|\{\$'.$key.":".$level.'\}|sU';
               } else {
                   $pat = '|\{\$'.$key.'\}|sU';
               }
               $rep = $val;
               $str = preg_replace($pat, $rep, $str);
           }
       }
       return $str;

    
    
    }


}
