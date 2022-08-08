<?php 

use libs\app\Request as Request;

function request($elements){
    return new Request($elements);
}

function body($vars = []){
    $raw = Request::raw();
    $res = [];
    foreach ($vars as $key) {
        if(!isset($raw[$key]))
            response("Bad Request - ".$key, 400);
        $res[$key] = $raw[$key];
    }
    return $res;
}

function response($response = "", $code = 200){
    echo json_encode([
        "code" => $code,
        "response" => $response
    ]);
    exit;
}