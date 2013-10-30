<?php

echo "HERE";
require_once("../utils/db_connect.php");

$answer = "OK";
$user_id = 2;
$task_id = 2;

switch($answer){
  case "OK":
   $cmd = "SELECT `solved_tasks` , `OK`
           FROM  `users` 
           WHERE  `user_id` =" . $user_id;
   $query = $connection->query($cmd);
   $arr = $query->fetch_array();
   $current_OK = $arr[1];
   if($arr[0] == "")$solved = array();
   else $solved = split("/" , $arr[0]);
   if(!in_array($task_id , $solved)){
     $cmd = "SELECT `people_solved`
             FROM  `tasks`
             WHERE  `id` =" . $task_id;
    $query = $connection->query($cmd);
    $arr = $query->fetch_array();
    $old_solutions = $arr[0];
    echo $old_solutions . "<br>";
    $cmd = "UPDATE `tasks` SET `people_solved` =  '".($old_submissions+1)."' WHERE `id` =".$task_id;
    //$solved[sizeof($solved)] = $task_id;
    //$solved = join("/" , $solved);
    //$cmd = "UPDATE `users` SET  `solved_tasks`='" . $solved . "' WHERE `user_id` =" . $user_id;
    //$connection->query($cmd);
                                    }
   //$cmd = "UPDATE `users` SET  `OK`='" . ($current_OK+1) . "' WHERE `user_id` =" . $user_id;
   //$connection->query($cmd);
   break;
  case "RE":
   $cmd = "SELECT `SEG_RE`
           FROM  `users`
           WHERE  `user_id` =" . $user_id;
   $query = $connection->query($cmd);
   $arr = $query->fetch_array();
   $current_SEG_RE = $arr[0];
   $cmd = "UPDATE `users` SET  `SEG_RE`='" . ($current_SEG_RE+1) . "' WHERE `user_id` =" . $user_id;
   $connection->query($cmd);
   break;
}

?>
