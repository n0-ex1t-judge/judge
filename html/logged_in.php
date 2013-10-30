<?php
$not_show = 0;
if (isset($_GET["uname"])) {
  $not_show = 1;
}

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$action = "tasks";
if(isset($_GET['action']))
 $action = $_GET['action'];
?>

<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>n0 ex1t online judge</title>
<meta name="description" content="TODO">
<meta name="keywords" content="TODO">
<link href="/bootstrap/css/bootstrap.css" media="all" rel="stylesheet" />
<link href="/bootstrap/css/bootstrap.min.css" media="all" rel="stylesheet" />
<link href="/bootstrap/css/bootstrap-responsive.css" media="all" rel="stylesheet" />
<link href="/bootstrap/css/bootstrap-responsive.min.css" media="all" rel="stylesheet" />
<script src="/bootstrap/js/bootstrap.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

<!--[if IE]><style>.menu a, .menu a:hover { width: 100%; }</style><![endif]-->
</head>

<body>
<table class="main" cellpadding="0" cellspacing="0">
<tbody>

<tr>
<td class="title" colspan="2">
<p>n0 ex1t judge</p>
</td>
</tr>

<tr>
<td class="menu">
<?php echo "<p style =\"color:black;font-size:medium;\" >Влязъл като: <br>" .
           $user . "</p>"; ?>
<hr>
<ul>
 <li>
  <a href="index.php?action=tasks" <?php if($action == "tasks")echo "class=current"; ?> >Задачи</a>
 </li>
 <li>
  <a href="index.php?action=contests" <?php if($action == "contests")echo "class=current"; ?> >Състезания</a>
 </li>
 <li>
  <a href="" <?php if($action == "virtual_contests")echo "class=current"; ?> >Виртуални<br>състезания</a>
 </li>
 <li>
  <a href="index.php?action=profile" <?php if($action == "profile" && $not_show == 0)echo "class=current"; ?> >Моят профил</a>
 </li>
 <li>
  <a href="index.php?action=status" <?php if($action == "status")echo "class=current"; ?> >Статус</a>
 </li>
 <li>
  <a href="" <?php if($action == "coaches")echo "class=current"; ?> >За треньори</a>
 </li>
 <li>
  <a href="index.php?logout">Изход</a>
 </li>
</td>
<td class="content" style="height:1000px">
 <?php if($action == "tasks")include("generate_task_list.php"); ?>
 <?php if($action == "status")include("status.php"); ?>
 <?php if($action == "profile")include("profile.php"); ?>
 <?php if($action == "contests")include("show_contest_list.php"); ?>
</td>
</tr>

</tbody>
</table>
</body>

</html>

<?php $connection->close(); ?>
