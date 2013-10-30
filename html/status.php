<script src="js/ajaxsbmt.js" type="text/javascript"></script>

<center>
<table width = "900px">

<tr>
<td style="width:100%">
<h2>Последните 30 изпратени решения: </h2>
<table style="width:100%;">
<tr>
<th>id</th> 
<th>Изпратено на</th>
<th>Потребител</th>
<th>Задача</th>
<th>Отговор</th>
</tr>
<?php
$cntr = 0;
$cmd = "SELECT `answer` , `submit_time`, `user`, `id`, `task_id`
        FROM  `runs` 
        ORDER BY `submit_time` DESC LIMIT 30";
$query = $connection->query($cmd);
while($ans = $query->fetch_array()){
  echo "<tr>";
  $username = "SELECT `user_name` FROM `users` WHERE user_id=" . $ans[2];
  $userquery = $connection->query($username);
  $userrr = $userquery->fetch_array()[0];
  
  $tasksql = "SELECT `name` FROM `tasks` WHERE id=" . $ans[4];
  $taskquery = $connection->query($tasksql);
  $taskname = $taskquery->fetch_array()[0];

  $link_to_user = "<a href=\"index.php?action=profile&uname=" . $userrr . "\">" . $userrr . "</a>";
  $link_to_task = "<a href=\"index.php?action=tasks&todo=show_problem&id=" . $ans[4] . "\">" . $taskname . "</a>";

  if($cntr%2 == 1) {
   echo "<td style=\"width:5%;background-color:#DAD9D9\">" . $ans[3] . "</td>";
   echo "<td style=\"width:20%;background-color:#DAD9D9\">" . $ans[1] . "</td>";
   echo "<td style=\"width:30%;background-color:#DAD9D9\">" . $link_to_user . "</td>";
   echo "<td style=\"width:30%;background-color:#DAD9D9\">" . $ans[4] . ". " . $link_to_task . "</td>";
  } else {
   echo "<td style=\"width:5%;white\">" . $ans[3] . "</td>";
   echo "<td style=\"width:20%;white\">" . $ans[1] . "</td>";
   echo "<td style=\"width:30%;white\">"  . $link_to_user . "</td>";
   echo "<td style=\"width:30%;white\">" . $ans[4] . ". " . $link_to_task . "</td>";
  }

  if($ans[0] == "OK")
   echo "<td style=\"background-color:#3DFA92\">" . $ans[0] . "</td>";
  else
   echo "<td style=\"background-color:#FE6868\">" . $ans[0] . "</td>";
  ++$cntr;
  echo "</tr>";
}
?>
</table>
<hr>
</td>
</tr>

</table>

</center>
