<!DOCTYPE html>
<html>
 <head>
  <link href="../bootstrap/css/bootstrap.css" media="all" rel="stylesheet" />
  <link href="../bootstrap/css/bootstrap.min.css" media="all" rel="stylesheet" />
  <link href="../bootstrap/css/bootstrap-responsive.css" media="all" rel="stylesheet" />
  <link href="../bootstrap/css/bootstrap-responsive.min.css" media="all" rel="stylesheet" />
  <script src="../bootstrap/js/bootstrap.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
 </head>
<body>

<!-- errors & messages --->
<center>
<div class="offset3 span6 well" style="background-color:#7777AA;color:white;">
<p><b>n0 ex1t judge</b></p>
<?php

// show negative messages
if ($login->errors) {
    foreach ($login->errors as $error) {
        echo $error;    
    }
}

// show positive messages
if ($login->messages) {
    foreach ($login->messages as $message) {
        echo $message;
    }
}

?>
<!-- errors & messages --->

<!-- login form box -->
<form role="form" method="post" action="index.php" name="loginform">
  <div class="form-group">
    <input id="login_input_username" placeholder="Потребителко име" class="login_input" type="text" name="user_name" required />
  </div>
  <div class="form-group">
    <input id="login_input_password" placeholder="Парола" class="login_input" type="password" name="user_password" autocomplete="off" required />
  </div>
    <input type="submit" class="btn btn-default" name="login" value="Влез" />

</form>

<a href="register.php" style="color:white">Регистрация на нов потребител</a>

</div>
</center>

</body>
</html>:
