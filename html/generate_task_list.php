<?php

$todo = "show_all_problems";
if(isset($_GET["todo"]))
 $todo = $_GET["todo"];

if($todo == "show_problem"){
  include("show_problem.php");
}

if($todo == "show_all_problems"){
/////////////////////////////////
echo "<h1>Задачи</h1>" .
     "<br>" .
     "<h2>Том 1:</h2>" .
     "<br>";

require_once("utils/db_connect.php");

$cmd = "SELECT `id`,`name`,`memory_limit`,`time_limit` , `people_solved`
        FROM  `tasks` 
        WHERE  `visible` =1";

$query = $connection->query($cmd);

echo "<table style=\"width:600px\">";
echo "<tr>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>ID</b></td>";
echo "<td style=\"width:40%;background-color:#FFCC66\"><b>Name</b></td>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>ML</b></td>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>TL</b></td>";
echo "<td style=\"width:15%;background-color:#FFCC66\"><b>Solutions</b></td>";
echo "</tr>";

$cntr = 0;

while($arr = $query->fetch_array()){
  ++$cntr;
  $task_url = "index.php?action=tasks&todo=show_problem&id=" . $arr[0];
  if($cntr%2 == 1){
   echo "<tr>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $arr[0] . "</td>";
   echo "<td style=\"width:40%\"><a href=\"" . $task_url . "\">" . $arr[1] . "</a></td>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $arr[2] . " Mb</td>";
   echo "<td style=\"width:15%\">" . $arr[3] . " sec</td>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $arr[4] . "</td>";
   echo "</tr>";
                  }
  else{
   echo "<tr>";
   echo "<td style=\"width:15%\">" . $arr[0] . "</td>";
   echo "<td style=\"width:40%;background-color:#E6E6DA\"><a href=\"" . $task_url.
         "\">" . $arr[1] . "</a></td>";
   echo "<td style=\"width:15%\">" . $arr[2] . " Mb</td>";
   echo "<td style=\"width:15%;background-color:#E6E6DA\">" . $arr[3] . " sec</td>";
   echo "<td style=\"width:15%\">" . $arr[4] . "</td>";
   echo "</tr>";
      }
}
echo "</table>";
/////////////////////////////
}
?>
