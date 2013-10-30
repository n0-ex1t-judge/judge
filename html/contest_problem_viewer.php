<?php
$task_id = $_GET["problem_id"];
$statement = "tasks/" . $task_id . "/statement.pdf";
?>

<script src="js/ajaxsbmt.js" type="text/javascript"></script>

<center>


<table width = "900px">

<tr>
<td style="width:100%">
<object style="width:900px;height:500px;" type="application/pdf" data="<?php echo $statement ?>" width="90%" height="90%"></object >
<hr>
</td>
</tr>

<tr>
<td style="width:100%">
<h2>Изпратени: </h2>
<table style="width:100%;">
<?php

$cntr = 0;
$cmd = "SELECT `answer` , `submit_time`
        FROM  `runs` 
        WHERE  `task_id` =".$task_id." AND `user` =" . $user_id . " ORDER BY `submit_time` DESC";

//echo $cmd;

$query = $connection->query($cmd);
while($ans = $query->fetch_array()){
  echo "<tr>";
  if($cntr%2 == 1)
   echo "<td style=\"width:70%;background-color:#DAD9D9\">" . $ans[1] . "</td>";
  else
   echo "<td style=\"width:70%;white\">" . $ans[1] . "</td>";
  if($ans[0] == "OK")
   echo "<td style=\"background-color:#3DFA92\">" . $ans[0] . "</td>";
  else
   echo "<td style=\"background-color:#FE6868\">" . $ans[0] . "</td>";
  ++$cntr;
  echo "</tr>";
}
if($cntr == 0){
  echo "<tr><td>";
  echo "Още не сте изпращали решения.";
  echo "</td></tr>";
}
?>
</table>
<hr>
</td>
</tr>

<tr>
<td style="width:100%;">
<h2>Изпращане: </h2>
<form id="solution_sender" method = "post" onsubmit = "xmlhttpPost('contest_submit_sol.php','solution_sender');
                                                       setTimeout('location.reload()' , 2000);
                                                       return false;">
 <input type="hidden" name="user" value="<?php echo $user_id; ?>" />
 <input type="hidden" name="task" value="<?php echo $task_id; ?>" />
 <input type="hidden" name="contest_id" value = "<?php echo $contest_id;?>" />
 <input type="submit" value="Изпращане"/> <br>
 <textarea name="solution" rows = "15" cols = "100">
  Копирай тук!
 </textarea>
 <br>
 <input type="submit" value="Изпращане"/>
</form>
</td>
</tr>

</table>

</center>
