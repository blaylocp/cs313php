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

// Get the content for a webpage
if($action === 'Webpage'){
  $_SESSION['webpageData'] = getWebpageData($_GET['pageCode']);
  $_SESSION['webpageComments'] = getCommentsWebpage($_GET['pageCode']);
  header('Location: /cms/templates/page.tpl.php');
}

// Redirect to the Login Page
elseif($action == 'LoginPage'){
  header('Location: /cms/templates/login.tpl.php');
}

// Login a client
elseif($action == 'Login'){
   $result = login($_POST['username'], $_POST['password']);

   if(empty($result)){
     $_SESSION['loginerror'] = "invalid username or password";
     header('Location: /cms/templates/login.tpl.php');
   }

   else{
     $_SESSION['LoginInfo'] = $result;
     header('Location: /cms/templates/home.tpl.php');
   }
}

// Login out a Client
elseif($action == 'Logout'){
  unset($_SESSION['LoginInfo']);
  $_SESSION['webpageData'] = getWebpageData($_GET['pageCode']);
  $_SESSION['webpageComments'] = getCommentsWebpage($_GET['pageCode']);
    header('Location: /cms/templates/home.tpl.php');
    //header('Location: /cms/templates/page.tpl.php');
}

// Register
elseif($action == 'Register'){
  unset($_SESSION['registerError']);
  $result = register($_POST['firstName'], $_POST['middleI'], $_POST['lastName'], $_POST['username'], $_POST['password']);

  if($result == -1){
    $_SESSION['registerError'] = "User Already Exsists!";
    header('Location: /cms/templates/register.tpl.php');
  }
  else{
      header('Location: /cms/templates/login.tpl.php');
  }
}

elseif($action == 'RegisterPage'){
  unset($_SESSION['registerError']);
  header('Location: /cms/templates/register.tpl.php');
}

// Add a Comment
elseif($action === 'Add Comment'){
  $userId = $_POST['userId'];
  $pageId = $_POST['pageId'];
  $comment = $_POST['comment'];

  $result = addComment($userId,$pageId,$comment);

  if($result){
    $_SESSION['webpageData'] = getWebpageData($pageId);
    $_SESSION['webpageComments'] = getCommentsWebpage($pageId);
    header('Location: /cms/templates/page.tpl.php');
  }
  else{
    $_SESSION['webpageData'] = getWebpageData($pageId);
    $_SESSION['webpageComments'] = getCommentsWebpage($pageId);
    header('Location: /cms/templates/page.tpl.php');
  }
}

// Update a User
elseif($action == 'Update User'){
  $result = updateUser($_POST['firstName'], $_POST['middleI'], $_POST['lastName'], $_POST['username'], $_POST['password'], $_POST['userId']);
    $_SESSION['editPages'] = getLinks();
    $_SESSION['editUsers'] = getUsers();
    header('Location: /cms/templates/admin.tpl.php');
}

// Update a Webpage
elseif($action == 'Update Page'){
  $pageId = $_POST['pageId'];
  $result = updatePage($_POST['pageId'], $_POST['pageTitle'], $_POST['pageImage'],$_POST['pageText']);
  if($result == 1){
    $_SESSION['navigationLinks'] = getLinks();
    $_SESSION['webpageData'] = getWebpageData($pageId);
    $_SESSION['webpageComments'] = getCommentsWebpage($pageId);
    header('Location: /cms/templates/page.tpl.php');
  }
  else{echo 'Didn\'t Update'; die;}
}

// Edit a Webpage
elseif($action == 'EditPage'){
  $pageCode = $_GET['editPagecCode'];
  $result = getWebpageData($pageCode);
  $_SESSION['editPage'] = $result;
  header('Location: /cms/templates/editpage.tpl.php');
}

// Insert webpage
elseif($action == 'Insert Page'){
  $result = insertPage($_POST['pageTitle'], $_POST['pageImage'], $_POST['pageText'], $_POST['userId']);
  $_SESSION['editPages'] = getLinks();
  $_SESSION['editUsers'] = getUsers();
  $_SESSION['navigationLinks'] = getLinks();
  header('Location: /cms/templates/admin.tpl.php');
}

// Edit a user
elseif($action =='EditUser'){
  $userCode = $_GET['editUserCode'];
  $result = getUsersData($userCode);
  $_SESSION['editUser'] = $result;
  header('Location: /cms/templates/edituser.tpl.php');
}

// Admin Page
elseif($action == 'Admin'){
  $_SESSION['editPages'] = getLinks();
  $_SESSION['editUsers'] = getUsers();
  header('Location: /cms/templates/admin.tpl.php');
}

// No action Redirect to the Home Page
else{
  $_SESSION['navigationLinks'] = getLinks();
  $webpageData['pageTitle'] = 'Home Page';
   header('Location: /cms/templates/home.tpl.php');
}
