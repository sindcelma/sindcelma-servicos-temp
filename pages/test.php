<?php 
/*
echo $content;
*/

$nome = "email_mkt_2_reuniao_finalizada.html";
$content = file_get_contents("../view/email_mkt/".$nome);
$content = str_replace("{{url}}", url("", true), $content);
//$content = str_replace("{{url}}", url(), $content);
echo $content;

file_put_contents("../view/email_mkt_final/".$nome, $content);