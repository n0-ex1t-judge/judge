<?php

$todo = "show_all_contests";
if(isset($_GET["todo"]))
 $todo = $_GET["todo"];

if($todo == "show_contest"){
  include("show_contest.php");
}

if($todo == "show_all_contests"){
/////////////////////////////////
echo "<h1>Състезания</h1><br><br>";

require_once("utils/db_connect.php");

$cmd = "SELECT `id`,`name`,`start_time`,`end_time`
        FROM  `contests` 
        WHERE  `visible` =1
        ORDER BY `start_time` DESC";
$query = $connection->query($cmd);

echo "<table style=\"width:700px\">";
echo "<tr>";
echo "<td style=\"width:10%;background-color:#FFCC66\"><b>ID</b></td>";
echo "<td style=\"width:30%;background-color:#FFCC66\"><b>Име</b></td>";
echo "<td style=\"width:14%;background-color:#FFCC66\"><b>Статус</b></td>";
echo "<td style=\"width:23%;background-color:#FFCC66\"><b>Начало</b></td>";
echo "<td style=\"width:23%;background-color:#FFCC66\"><b>Край</b></td>";
echo "</tr>";

$cntr = 0;
$current_time = time();

while($arr = $query->fetch_array()){
  ++$cntr;
  
  $start_time = strtotime($arr[2]);
  $end_time = strtotime($arr[3]);
  $status = "<b><font style=\"color:green\">Текущ</font></b>";
  if($current_time < $start_time)$status = "<b><font style=\"color:#CAC002\">Бъдещ</font></b>";
  if($current_time > $end_time)$status = "<b><font style=\"color:black\">Свършил</font></b>";
  
  $task_url = "index.php?action=contests&todo=show_contest&id=" . $arr[0];
  if($cntr%2 == 1){
   echo "<tr>";
   echo "<td style=\"background-color:#E6E6DA\">" . $arr[0] . "</td>";
   echo "<td style=\"\"><a href=\"" . $task_url . "\">" . $arr[1] . "</a></td>";
   echo "<td style=\"background-color:#E6E6DA\">" . $status . "</td>";
   echo "<td style=\"\">" . $arr[2] . "</td>";
   echo "<td style=\"background-color:#E6E6DA\">" . $arr[3] . "</td>";
   echo "</tr>";
                  }
  else{
   echo "<tr>";
   echo "<td style=\"\">" . $arr[0] . "</td>";
   echo "<td style=\"background-color:#E6E6DA\"><a href=\"" . $task_url.
         "\">" . $arr[1] . "</a></td>";
   echo "<td style=\"\">" . $status . "</td>";
   echo "<td style=\"background-color:#E6E6DA\">" . $arr[2] . "</td>";
   echo "<td style=\"\">" . $arr[3] . "</td>";
   echo "</tr>";
      }
}
echo "</table>";
/////////////////////////////
}
?>
