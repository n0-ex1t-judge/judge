<?php

$contest_id = $_GET["id"];

/////////////////////////////////
require_once("utils/db_connect.php");

$cmd = "SELECT `name`,`task_list`,`start_time` , `end_time`
        FROM  `contests` 
        WHERE  `visible` =1 AND `id` =" . $contest_id;

$query = $connection->query($cmd);
$arr = $query->fetch_array();

$name = $arr[0];
$task_list = $arr[1];
$start_time = $arr[2];
$end_time = $arr[3];

$unix_begin = strtotime($start_time);
$unix_end = strtotime($end_time);
$current_time = time();

if($current_time > $unix_end){
  if(!isset($_GET["scoretable"])){
   echo "<h3>Състезанието е вече свършило</h3><br><br>";
   echo "<a href = \"index.php?action=contests&todo=show_contest&id=" . $contest_id . "&scoretable\"><b>Класация</b></a><br><br>";
                                 }
  else{
   include("show_scoretable.php");
      }
} else if($current_time < $unix_begin){
         echo "<h3>Състезанието още не е започнало</h3>";
} else{

if(isset($_GET["show_problem"])){
  include("contest_problem_viewer.php");
}
else if(isset($_GET["scoretable"])){
  include("show_scoretable.php");
}
else{
/////// Contest index page
echo "<h1>Задачи от " . $name . "</h1><br><br>";
//////// Running contest 
$task_list = split("/" , $task_list);
echo "<b>Оставащо време:</b> " . gmdate("H:i:s", $unix_end - $current_time) .
     "<br><br>";
echo "<a href = \"index.php?action=contests&todo=show_contest&id=" . $contest_id . "&scoretable\"><b>Класация</b></a><br><br>";
echo "<table style=\"width:600px\">";
echo "<tr>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>ID</b></td>";
echo "<td style=\"width:40%;background-color:#FFCC66\"><b>Name</b></td>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>ML</b></td>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>TL</b></td>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>Solutions</b></td>";
echo "</tr>";

$cntr = 0;
foreach($task_list as $task){
  ++$cntr;
  // getting problem info
  $cmd = "SELECT `name`,`memory_limit`,`time_limit` , `people_solved`
          FROM  `tasks`
          WHERE  `id` =" . $task;
  $query = $connection->query($cmd);
  $arr = $query->fetch_array();
  $cur_name = $arr[0];
  $cur_ML = $arr[1];
  $cur_TL = $arr[2];
  $cur_SOLUTIONS = $arr[3];
  ///////////////////////
  $task_url = "index.php?action=contests&todo=show_contest&id=".$contest_id."&show_problem&problem_id=".$task;
  if($cntr%2 == 1){
   echo "<tr>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $task . "</td>";
   echo "<td style=\"width:40%\"><a href=\"" . $task_url . "\">" . $cur_name . "</a></td>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $cur_ML . " Mb</td>";
   echo "<td style=\"width:15%\">" . $cur_TL . " sec</td>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $cur_SOLUTIONS . "</td>";
   echo "</tr>";
                  }
  else{
   echo "<tr>";
   echo "<td style=\"width:15%\">" . $task . "</td>";
   echo "<td style=\"width:40%;background-color:#E6E6DA\"><a href=\"" . $task_url.
         "\">" . $cur_name . "</a></td>";
   echo "<td style=\"width:15%\">" . $cur_ML . " Mb</td>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $cur_TL . " sec</td>";
   echo "<td style=\"width:15%\">" . $cur_SOLUTIONS . "</td>";
   echo "</tr>";
      }
}
echo "</table>";
// End of contest index page
}
//////// End running contest
}
?>
