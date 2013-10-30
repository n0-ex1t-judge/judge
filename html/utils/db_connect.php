<?php

define("DB_HOST", "46.21.145.138");
define("DB_NAME", "judge");
define("DB_USER", "root");
define("DB_PASS", "vladi");

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($connection->connect_errno)die(0);

?>

