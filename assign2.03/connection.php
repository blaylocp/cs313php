<?php


  $connection = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

  // $connection = new mysqli($host, $username, $password, $database);

  if(mysqli_connect_error()){
    echo 'bad connection';
  }
?>
