<?php
  if (isset($_GET["uname"])) {
    $uname = $_GET["uname"];
  } else {
    $uname = $user;
  }
  echo $uname;
?>
<h2> Профил на <?php echo $uname; ?></h2>
<?php
  $statement = "SELECT `solved_tasks` FROM `users` WHERE user_name=" . $uname;
  $solved_query = connector->query($statement); 
  $solved = $solved_query.fetch_array()[0];
  echo $solved;
?>


