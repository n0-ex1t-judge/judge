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
<div class="span6 offset3 well" style="background-color:#7777AA;color:white;"> 
<p><b>n0 ex1t judge</b></p>
<?php

// show negative messages
if ($registration->errors) {
    foreach ($registration->errors as $error) {
        echo $error;    
    }
}

// show positive messages
if ($registration->messages) {
    foreach ($registration->messages as $message) {
        echo $message;
    }
}

?>
<!-- errors & messages --->

<!-- register form -->
<form role="form" method="post" action="register.php" name="registerform">   
    <div class="form-group">
    <!-- the user name input field uses a HTML5 pattern check -->
      <input id="login_input_username" class="login_input form-control" 
             placeholder="Потребителско име" type="text" 
             pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /> 
    </div>

    <div class="form-group">
      <!-- the email input field uses a HTML5 email type check -->
      <input id="login_input_email" class="login_input form-control" 
             placeholder="Вашият email адрес" type="email" name="user_email" required />        
    </div>

    <div class="form-group">
      <input id="login_input_password_new" class="login_input form-control" placeholder="Парола (поне 6 символа)"
             type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /> 
    </div>

    <div class="form-group">
      <input id="login_input_password_repeat" class="login_input" type="password" 
             placeholder="Повторете паролата" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />        
    </div>
    <input type="submit" class="btn btn-default" name="register" value="Регистрирай се" />
    
</form>

<!-- backlink -->
<a href="index.php" style="color:white">Обратно</a>
</div>
</center>
</body>
</html>
