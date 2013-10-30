<?php

$task_id = $_POST["task"];
$user = $_POST["user"];

require_once("utils/db_connect.php");

$cmd = "SHOW TABLE STATUS LIKE 'runs';";
$query = $connection->query($cmd);
$data = $query->fetch_assoc();
$run_id = $data['Auto_increment'];

//////// Contest log
$contest_id = $_POST["contest_id"];

$cmd = "SELECT `log`
        FROM  `contests`
        WHERE  `id` =" . $contest_id;

$query = $connection->query($cmd);
$old_log = $query->fetch_array()[0];

$current_run = $run_id;

if($old_log == "")$old_log = $current_run;
else $old_log .= "/" . $current_run;

$cmd = "UPDATE `contests` SET `log` =  '" . $old_log . "' WHERE  `id` =" . $contest_id;
$connection->query($cmd);
//////// End

$cmd = "INSERT INTO  `judge`.`runs` (
        `id` ,
        `user` ,
        `answer` ,
        `points` ,
        `submit_time` ,
        `runtime` ,
        `used_memory` ,
        `task_id`
                                    )
       VALUES (
        NULL ,  '" . $user . "',  'judging',  '',
        CURRENT_TIMESTAMP ,  '',  '',  '" . $task_id . "'
              );";

$connection->query($cmd);

$cpp_file = "submissions/" . $run_id . ".cpp";
$handle = fopen($cpp_file, 'w');
fwrite($handle, $_POST["solution"]);
fclose($handle);
chmod(777 , $cpp_file);

require_once("tester.php");

?>
