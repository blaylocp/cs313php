<?php echo 'THIS IS DUMB'; die; ?>

<?php
/***********************************************
 * Main Controller for the CMS
 ***********************************************/
// Start the Session


session_start();

// Include the Model
if(file_exists('/model/model.php')){
  require_once '/model/model.php';
}
else{
  include '/templates/error.tpl.php'
}


// Capture the action and assign it to a variable
if($_GET['action']){
  echo $action = $_GET['action'];
} elseif ($_POST['action']){
  echo $action = $_POST['action'];
}

// Get the Navigation Links
$_SESSION['navigationLinks'] = getLinks();

if($action == 'Webpage'){
    $_SESSION['webpageData'] = getWebpageData($_GET['pageCode']);
    include 'page.tpl.php'
}

// elseif($action == ''){
//
// }
//
// elseif($action == ''){
//
// }


/*else{
  include '/templates/home.tpl.php';
}*/
