<?php 

$content = file_get_contents("../view/email_mkt/pattern.html");
$content = str_replace("{{url}}", url(), $content);
echo $content;