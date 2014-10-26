<?php
// Start the Session
session_start();

// Include the Model

if(file_exists($_SERVER['DOCUMENT_ROOT']) . 'model.php'){
  require_once($_SERVER['DOCUMENT_ROOT'] . 'model.php');
}
else{
 echo 'Model Error'; die;
}


// Capture the Action
if($_GET['action']){
   $action = $_GET['action'];
} elseif ($_POST['action']){
   $action = $_POST['action'];
}

// Get the Navigation Links
$_SESSION['topics'] = getTopics();

if($action == 'insertScripture'){
  $book = $_POST['book'];
  $chapter = $_POST['chapter'];
  $verse = $_POST['verse'];
  $content = $_POST['content'];
  $topics = $_POST['topics'];

  insertScripture($book,$chapter,$verse,$content,$topics);
  
  header('Location: view.php');
}

else{
  header('Location: view.php');
}
