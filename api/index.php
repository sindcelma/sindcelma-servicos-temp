<?php 

header('Content-Type: application/json; charset=utf-8');

(function(){
    
    $req = request(['req', 'service', 'func'])->vars;
    $file_service = "../api/services/".$req['service'].".php";
    
    if(!file_exists($file_service))
        response("Serviço não existe ou não está disponível", 404);
        
    include $file_service;
    $func = $req['func'];

    if(!function_exists($func))
        response("Serviço não existe ou não está disponível", 404);

    $func();
    response();

})();
