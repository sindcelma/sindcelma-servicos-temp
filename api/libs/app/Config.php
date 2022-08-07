<?php 

namespace libs\app;

class Config {

    private static $instance = false;
    private $data, $url;
    private $database;

    private function __construct(){
        $conf = json_decode(file_get_contents("../config.json"), true);
        $this->data = $conf;
        $isInProduction = $conf['production'];
        $database = $isInProduction ? "../database.prod.json" : "../database.local.json"; 
        $this->url = $isInProduction ? $conf['url_prod'] : $conf['url_dev'];
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

    public static function url($uri = ""){

        return self::instance()->url.$uri;
    }

    public static function is_in_production(){

        return self::instance()->data['production'];
    }

    public static function database(){
        return self::instance()->database;
    }


}