<form name="bookScriptures" action="." method="post">
  <input type="text" value="book"></input>
  <input type="submit">
</form>

<?php

  if($_GET['action']){
    $action = $_GET['action'];
  } elseif ($_POST['action']){
    $action = $_POST['action'];
  }


if($action == "submit"){
  $book = $_POST['book']
  $results = getBooks($book);

  for($results as $scriptures){
    echo "<b>" . $scriptures[1] . " " . $scriptures[2] . ":" . $scriptures[3] . "</b> - " . $scriptures[4] . "<br />";
  }
}

function getBooks($book){

  $con
  $con->autocommit(FLASE);

  $sql = SELECT * FROM Scriptures WHERE =
  if($stmt = $con->prepare($sql)){
    $stmt->bind_param('s', $book);
    $stmt->bind_results($id, $book, $chapter, $verse, $content)
    $result = array();
    $row = array();
    $stmt->execute();
    while($stmt->fetch()){
      $row[0] = $id;
      $row[1] = $book;
      $row[2] = $chapter;
      $row[3] = $verse;
      $row[5] = $content;
      $result = $row;
    }

    $stmt->close();

    if(!empty($result)){
      return $result;
    }
    else{
      return 0;
    }
  }
}
?> 
