<?php 

include "../api/autoload.php";
include "../api/helpers/request.php";
include "../api/helpers/app.php";
include "../api/helpers/sqli.php";

$req = request(['req'])->vars['req'];

if($req == 'api'){
    include "../api/index.php";
    exit;
}

$file = "../pages/$req.php";

include (file_exists($file) ? $file : "../pages/error.php");