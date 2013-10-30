<?php
  if (isset($_GET["uname"])) {
    $uname = $_GET["uname"];
  } else {
    $uname = $user;
  }
?>
<h2> Профил на <?php echo $uname; ?></h2>
<br>
<h3> Статистика </h3>
<?php
$statement = "SELECT `TL_ML` , `WA` , `SEG_RE` , `OK` , `CE`
              FROM `users` 
              WHERE user_name='" . $uname . "'";
$solved_query = $connection->query($statement);
$arr = $solved_query->fetch_array();
$TL_ML = $arr[0];
$WA = $arr[1];
$SEG_RE = $arr[2];
$OK = $arr[3];
$CE = $arr[4];
?>
<table style="width:400px">
<tr>
 <td style="width:20%;background-color:#FFCC66"><b>OK</b></td>
 <td style="width:20%;background-color:#FFCC66"><b>WA</b></td>
 <td style="width:20%;background-color:#FFCC66"><b>SEG/RE</b></td>
 <td style="width:20%;background-color:#FFCC66"><b>TL/ML</b></td>
 <td style="width:20%;background-color:#FFCC66"><b>CE</b></td>
</tr>
<tr>
 <td style="width:20%;"><?php echo $OK; ?></td>
 <td style="width:20%;"><?php echo $WA; ?></td>
 <td style="width:20%;"><?php echo $SEG_RE; ?></td>
 <td style="width:20%;"><?php echo $TL_ML; ?></td>
 <td style="width:20%;"><?php echo $CE; ?></td>
</tr>
</table>
<br><br>
<?php
  $statement = "SELECT `solved_tasks` FROM `users` WHERE user_name='" . $uname . "'";
  $solved_query = $connection->query($statement); 
  $solved = $solved_query->fetch_array()[0];
  $arr_solved = array_map('intval', explode('/', $solved));

  $fail = 0;
  if (count($arr_solved) == 0) $fail = 1;

  foreach ($arr_solved as $task) {
    if ($task <= 0)
      $fail = 1;
  }
  
  if ($fail == 1) {
    echo $uname . " няма решени задачи!";
  } else {
  
  $statement = "SELECT COUNT(*) FROM `tasks`";
  $cnt_query = $connection->query($statement);
  $total = $cnt_query->fetch_array()[0];
  $this_user = count($arr_solved);
?>
 <h4> Решени задачи [<?php echo $this_user . " от " . $total; ?>]</h4>
 <table>
   <tbody>
<?php
    

  $tasks_per_row = 5;
  $i = 0;
  sort($arr_solved);
  foreach ($arr_solved as $task) {
    ++$i;
    if ($i % $tasks_per_row == 1) {
	echo "<tr>";
    }
    $statement = "SELECT `name` from `tasks` WHERE id=" . $task;
    $task_query = $connection->query($statement);
    $task_name = $task_query->fetch_array()[0];
    echo "<td style=\"background-color:#3DFA92; color:black; width:150px;\">" . $task . ". " . 
         "<a href=\"index.php?action=tasks&todo=show_problem&id=" . $task . "\" style=\"color:black\">" . $task_name . "</a>" .
         "</td> ";
    if ($i % $tasks_per_row == 0) {
	echo "</tr>\n";
    }
  }
  if ($i % $tasks_per_row != 0) {
      echo "</tr>\n";
  }
?>
</tbody>
</table>
<?php } ?>

