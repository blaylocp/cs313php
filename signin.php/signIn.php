<?php

if($_GET['action']){
   $action = $_GET['action'];
} elseif ($_POST['action']){
   $action = $_POST['action'];
}

if($action == submit){
  $password = $_POST['password'];
  $username = $_POST['username'];

  $db_host = $_ENV['OPENSHIFT_MYSQL_DB_HOST'];
  $db_user = $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'];
  $db_pass = $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'];
  $db_name = $_ENV['OPENSHIFT_APP_NAME'];
  $db_port = $_ENV['OPENSHIFT_MYSQL_DB_PORT'];

  $connection = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

  $sql = 'SELECT password FROM users WHERE username=?';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('s', $username );
    $stmt->bind_result( $userPassword);
    $stmt->execute();
    $stmt->fetch();
  }

  if(!empty($userPassword)){
    if (password_verify($password, $userPassword))
    {
      // password was correct, put the user on the session, and redirect to home
      $_SESSION['signedIn'] = $username;
      header("Location: home.php");
      die(); // we always include a die after redirects.
    }
  }

}


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign In</title>
</head>
<body>
<h1>Sign In Page</h1>
<form method="post" action="">
<label>Username</label> <br>
<input type="text" name="username"/><br>
<label>Password</label><br>
<input type="password" name="password" /><br>
<input type="submit" name="action" value="submit"/>
</form>
</body>
</html>
