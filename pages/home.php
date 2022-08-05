<?php 

include "../api/helpers/sqli.php";

echo _query("SELECT count(*) as total FROM mailing")->fetchAssoc()['total'];