<?php
/***********************************************
 * Main Controller for the CMS
 ***********************************************/
// Start the Session
session_start();

// Include the Model

if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/cms/model/model.php')){
  require_once($_SERVER['DOCUMENT_ROOT'] . '/cms/model/model.php');
}
else{
  header('Location: /cms/templates/error.tpl.php');
  //include 'templates/error.tpl.php';
}


// Capture the action and assign it to a variable
if($_GET['action']){
   $action = $_GET['action'];
} elseif ($_POST['action']){
   $action = $_POST['action'];
}

// Get the Navigation Links
$_SESSION['navigationLinks'] = getLinks();

if($action === 'Webpage'){
  $_SESSION['webpageData'] = getWebpageData($_GET['pageCode']);
  $_SESSION['webpageComments'] = getCommentsWebpage($_GET['pageCode']);
  header('Location: /cms/templates/page.tpl.php');
}

// elseif($action == ''){
//
// }
//
// elseif($action == ''){
//
// }

else{
  $webpageData['pageTitle'] = 'Home Page';
   header('Location: /cms/templates/home.tpl.php');
}
