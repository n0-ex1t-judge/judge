<?php

//if(!isset($_GET["id"]))die(0);

require_once("utils/db_connect.php");
//$run_id = $_GET["id"];

$ask = "SELECT `task_id` FROM `runs` WHERE  `id` =" . $run_id;
$query = $connection->query($ask);
$task_id = $query->fetch_array();
$task_id = $task_id[0];

$ask = "SELECT `tests`,`memory_limit`,`time_limit` FROM `tasks` WHERE  `id` =" . $task_id;
$query = $connection->query($ask);
$tests = $query->fetch_array();
$ML = $tests[1] * 1024 * 1024;
$TL = $tests[2];
$tests = $tests[0];

$task_name = "submissions/" . $run_id . ".cpp";
$exe_name = "submissions/" . $run_id;

exec("g++ -O2 " . $task_name . " -o " . $exe_name , $compile_output , $compile_code);

$answer = "OK"; 

if($compile_code != 0)$answer = "CE";
else{
 $test_names = split("/" , $tests);
 foreach($test_names as $test_name){
  $cmd = "./runner ".$TL." ".$ML." submissions/".$run_id." tasks/".$task_id."/".$test_name." submissions/".$run_id.".out";
  exec($cmd , $out , $code);
  if($code != 0){
   if($code == 1)$answer = "TL/ML";
   else if($code == 2)$answer = "SEG";
        else $answer = "RE";
   unlink("submissions/".$run_id.".out");
   break;
                }
  chmod("submissions/".$run_id.".out" , 777);  
  $cmd = "tasks/".$task_id."/checker "."tasks/".$task_id."/".$test_name." submissions/".$run_id.".out".
         " tasks/".$task_id."/".$test_name.".out";

  exec($cmd , $out , $code);
  unlink("submissions/".$run_id.".out");
  if($code != 0){
   $answer = "WA";
   break;
                } 
                                   }
    }
unlink($task_name);
unlink($exe_name);

//echo $answer;

$connection->query("UPDATE `judge`.`runs` SET `answer` =  '" . $answer . "' WHERE  `runs`.`id` =" . $run_id . ";");

// Updating user stats

$user_id = $user;

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
    $solved[sizeof($solved)] = $task_id;
    $solved = join("/" , $solved);
    $cmd = "UPDATE `users` SET  `solved_tasks`='" . $solved . "' WHERE `user_id` =" . $user_id;
    $connection->query($cmd);
    // Updating task info
    $cmd = "SELECT `people_solved`
            FROM  `tasks` 
            WHERE  `id` =" . $task_id;
    $query = $connection->query($cmd);
    $arr = $query->fetch_array();
    $old_solutions = $arr[0];
    $cmd = "UPDATE `tasks` SET `people_solved` =  '".($old_solutions+1)."' WHERE `id` =".$task_id;
    $connection->query($cmd);
    /////////////////////
                                    }
   $cmd = "UPDATE `users` SET  `OK`='" . ($current_OK+1) . "' WHERE `user_id` =" . $user_id;
   $connection->query($cmd);
   break;
  case "RE": case "SEG":
   $cmd = "SELECT `SEG_RE`
           FROM  `users`
           WHERE  `user_id` =" . $user_id;
   $query = $connection->query($cmd);
   $arr = $query->fetch_array();
   $current_SEG_RE = $arr[0];
   $cmd = "UPDATE `users` SET  `SEG_RE`='" . ($current_SEG_RE+1) . "' WHERE `user_id` =" . $user_id;
   $connection->query($cmd);
   break;
  case "TL/ML":
   $cmd = "SELECT `TL_ML`
           FROM  `users`
           WHERE  `user_id` =" . $user_id;
   $query = $connection->query($cmd);
   $arr = $query->fetch_array();
   $current_TL_ML = $arr[0];
   $cmd = "UPDATE `users` SET  `TL_ML`='" . ($current_TL_ML+1) . "' WHERE `user_id` =" . $user_id;
   $connection->query($cmd);
   break;
  case "CE":
   $cmd = "SELECT `CE`
           FROM  `users`
           WHERE  `user_id` =" . $user_id;
   $query = $connection->query($cmd);
   $arr = $query->fetch_array();
   $current_CE = $arr[0];
   $cmd = "UPDATE `users` SET  `CE`='" . ($current_CE+1) . "' WHERE `user_id` =" . $user_id;
   $connection->query($cmd);
   break;
  case "WA":
   $cmd = "SELECT `WA`
           FROM  `users`
           WHERE  `user_id` =" . $user_id;
   $query = $connection->query($cmd);
   $arr = $query->fetch_array();
   $current_WA = $arr[0];
   $cmd = "UPDATE `users` SET  `WA`='" . ($current_WA+1) . "' WHERE `user_id` =" . $user_id;
   $connection->query($cmd);
   break;

}
///////////////////////////

?>
