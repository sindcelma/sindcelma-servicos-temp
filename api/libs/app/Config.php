<?php 

namespace libs\app;

class Config {

    private static $instance = false;
    private $data, $url;
    private $database;

    private function __construct(){
        $conf = json_decode(file_get_contents("../config.json"), true);
        $this->data = $conf;
        $database =  $conf['production'] ? "../database.prod.json" : "../database.local.json"; 
        $this->database = json_decode(file_get_contents($database), true);
    }

    private static function instance(){

        if(!self::$instance)
            self::$instance = new Config();

        return self::$instance;
    }

    public static function get(string $key = ""){

        $conf = self::instance()->data;
        
        if($key != "") 
            return (isset($conf[$key]) 
                        ? $conf[$key] 
                        : false);
                        
        return $conf;
    }

    public static function url(){

        return self::instance()->url;
    }

    public static function is_in_production(){

        return self::instance()->data['type'] == 'prod';
    }

    public static function database(){
        return self::instance()->database;
    }


}