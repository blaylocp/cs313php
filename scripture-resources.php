<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Scripture Resources</title>
</head>

<body>
<h1>Scripture Resources</h1>
<p>
<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = "conference_notes";

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
$sql = "SELECT * from SCRIPTURE";

$results = mysqli_query($con, $sql);

while ($data = mysqli_fetch_array($results)) {
	echo "<b>" . $data["book"] . " " . $data["chapter"] . ":" . $data["verse"] . "</b> - " . $data["content"] . "<br />";
}

?>

</p>

<form name="bookScriptures" action="scripture-resources.php" method="post">
  <input type="text" name="book" />
  <input type="submit" value="submit" />
</form>

<?php

  if($_GET['action']){
    echo $action = $_GET['action'];
  } elseif ($_POST['action']){
    echo $action = $_POST['action'];
  }

  echo "1";


if($action == "submit"){
	echo "2";
  $book = $_POST['book'];
  $results = getBooks($book);

  foreach($results as $scriptures){
    echo "<b>" . $scriptures[1] . " " . $scriptures[2] . ":" . $scriptures[3] . "</b> - " . $scriptures[4] . "<br />";
  }
}

function getBooks($book){
	echo "3";
  $sql = "SELECT * FROM Scriptures WHERE book=?";
  if($stmt = $con->prepare($sql)){
    $stmt->bind_param('s', $book);
    $stmt->bind_results($id, $book, $chapter, $verse, $content);
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
	echo "4";
	print_r($result);
	die;
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

</body>
</html>
