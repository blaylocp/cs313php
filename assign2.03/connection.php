<?php
  //locally
  // $host = 'localhost';
  // $username = 'root';
  // $password = '';
  // $database = 'survey';

  $host = '127.6.69.130';
  $username = 'adminLpXeHW3';
  $password = '6PhASee745Tt';
  $database = 'php';

  $connection = new mysqli($host, $username, $password, $database);

  if(mysqli_connect_error()){
    echo 'bad connection';
  }
?>
