<?php

require_once("config/db.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {
    $user = $_SESSION['user_name'];
    $logged = true;
    require_once("utils/db_connect.php");
    $cmd = "SELECT `user_id`
            FROM  `users`
            WHERE `user_name` LIKE  '" . $user . "';";
    $query = $connection->query($cmd);
    $arr = $query->fetch_array();
    $user_id = $arr[0];
    include("logged_in.php");
} else {
    $logged = false;
    include("not_logged_in.php");
}
