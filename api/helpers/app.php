<?php 

use libs\app\Config as Config;
use libs\app\Request as Request;

function config(string $key = ""){
    return Config::get($key);
}

function database(){
    return Config::database();
}

function request($elements){
    return new Request($elements);
}

function _is_in_production(){
    return Config::get("production");
}