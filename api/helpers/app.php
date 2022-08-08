<?php 

use libs\app\Config as Config;
use libs\app\Request as Request;

function _error(){
    include "../pages/error.php";
    exit;
}

function url(string $uri = "", bool $prod = false){
    return !$prod ? Config::url($uri) : Config::get("url_prod").$uri;
}

function _url(string $uri = "", bool $prod = false){
    echo !$prod ? Config::url($uri) : Config::get("url_prod").$uri;
}

function config(string $key = ""){
    return Config::get($key);
}

function database(){
    return Config::database();
}



function _is_in_production(){
    return Config::get("production");
}