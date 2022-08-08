<?php 
/*

echo $content;
*/

$content = file_get_contents("../view/email_mkt/pattern.html");
$content = str_replace("{{url}}", url("", true), $content);

file_put_contents("../view/email_mkt_final/pattern.html", $content);