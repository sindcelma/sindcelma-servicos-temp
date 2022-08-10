<?php 
/*

echo $content;
*/

$content = file_get_contents("../view/email_mkt/email_mkt_plano_de_lutas.html");
$content = str_replace("{{url}}", url("", true), $content);
//$content = str_replace("{{url}}", url(), $content);
echo $content;

file_put_contents("../view/email_mkt_final/email_mkt_plano_de_lutas.html", $content);