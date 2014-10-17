<?php
/***********************************************
 * Main Controller for the CMS
 ***********************************************/
echo 'Welcome to the Model'; 
// Include the connection
if(file_exists('/connection.php')){
  require_once 'connection.php';
  echo 'It Works';
}
else{
  echo 'no'; die;
  include '/templates/error.tpl.php'
}
