<?php
  //locally
  // $host = 'localhost';
  // $username = 'root';
  // $password = '';
  // $database = 'survey';

  // $host = '127.6.69.130:3306';
  // $username = 'adminLpXeHW3';
  // $password = '6PhASee745Tt';
  // $database = 'php';

  $db_host = $_ENV['OPENSHIFT_MYSQL_DB_HOST'];
  $db_user = $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'];
  $db_pass = $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'];
  $db_name = $_ENV['OPENSHIFT_APP_NAME'];
  $db_port = $_ENV['OPENSHIFT_MYSQL_DB_PORT'];

  $connection = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

  // $connection = new mysqli($host, $username, $password, $database);

  if(mysqli_connect_error()){
    echo 'bad connection';
  }
?>
