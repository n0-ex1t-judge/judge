<?php
 echo "<h1>Резултати от " . $name . "</h1>";
 $cmd = "SELECT `log` ,`task_list` 
         FROM  `contests`
         WHERE  `id` =" . $contest_id;

 $query = $connection->query($cmd);
 $arr = $query->fetch_array();
 $raw_log = $arr[0];
 $log = split("/" , $raw_log);

 // Task list
 $task_list = $arr[1];
 $task_list = split("/" , $task_list);
 foreach($task_list as $task){
  $cmd = "SELECT `name`
          FROM  `tasks`
          WHERE  `id` =" . $task;

  $query = $connection->query($cmd);
  $arr = $query->fetch_array();
  $name_map[$task] = $arr[0];
 }
 //////////// 

 foreach($log as $run){
  $cmd = "SELECT `answer` , `task_id` , `user`
          FROM  `runs`
          WHERE  `id` =" . $run;

  $query = $connection->query($cmd);
  $arr = $query->fetch_array();
  
  $answer = $arr[0];
  $task_id = $arr[1];
  $user = $arr[2];
  if($data[$user][$task_id] != "OK")
   $data[$user][$task_id] = $answer;
 }
 $people = array_keys($data);
 //echo "!" . sizeof($people);
 //if(sizeof($people) == 0){
 // echo "<br><br>Няма участници."; 
 //                        }
 //else{
// Printing
 foreach($people as $cur){
  foreach($data[$cur] as $tmp_val)
   if($tmp_val == "OK") ++$solved[$cur];
 }

 function cmp($f , $s){
  if($solved[$f] == $solved[$s])return 0;
  return ($solved[$f] > $solved[$s]) ? -1 : 1;
 }

 $len = sizeof($people);
 for($i=0;$i<$len;++$i)
  for($j=$i+1;$j<$len;$j++){
   if($solved[$people[$i]] < $solved[$people[$j]]){
    $tmp = $people[$i];
    $people[$i] = $people[$j];
    $people[$j] = $tmp;
                                                  }
                           } 

 echo "<br><br><br><table>";
 echo "<tr>";
 echo "<td style=\"width:100px\"></td>";
 foreach($task_list as $task){
   echo "<td style=\"width:90px\"><center><b>".$name_map[$task]."</b></center></td>";
 }
 echo "<td style=\"width:50px\"><center><b>Общо</b></center></td>";
 echo "</tr>";

 foreach($people as $cur){
  $cmd = "SELECT `user_name`
          FROM  `users`
          WHERE  `user_id` =" . $cur;
  $query = $connection->query($cmd);
  $cur_name = $query->fetch_array()[0];
  echo "<tr>";
  echo "<td><a href=\"index.php?action=profile&uname=".$cur_name."\">".$cur_name."</a></td>";
  foreach($task_list as $task){
    $to_write = "-";
    if(isset($data[$cur][$task])) $to_write = $data[$cur][$task];
    $color = "#E6E6DA";
    if($to_write == "OK") $color = "#3DFA92";
    else if($to_write != "-") $color = "#FE6868";
    echo "<td style=\"background-color:".$color."\"><center><b>".$to_write."</b></center></td>";
  }
  echo "<td><center>" . $solved[$cur] . "</center></td>";
  echo "</tr>";
 }
 echo "</table>";
 //}
?>
