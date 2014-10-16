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
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
$dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');

$dbName = "conference_notes";

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
$sql = "SELECT * from SCRIPTURE";

$results = mysqli_query($con, $sql);

while ($data = mysqli_fetch_array($results)) {
	echo "<b>" . $data["book"] . " " . $data["chapter"] . ":" . $data["verse"] . "</b> - " . $data["content"] . "<br />";
}

mysqli_close($con);
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


if(isset($_POST["book"])){
  $book = $_POST['book'];
  $results = getBooks($book);

  foreach($results as $scriptures){
    echo "<b>" . $scriptures[1] . " " . $scriptures[2] . ":" . $scriptures[3] . "</b> - " . $scriptures[4] . "<br />";
  }
}

function getBooks($book){
	$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
$dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');

$dbName = "conference_notes";

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
  $sql = "SELECT * FROM SCRIPTURE WHERE book=?";
  
  if($stmt = $con->prepare($sql)){
    $stmt->bind_param('s', $book);
	$stmt->execute();
    $stmt->bind_result($id, $book, $chapter, $verse, $content);
    $result = array();
    $row = array();
    while($stmt->fetch()){
      $row[0] = $id;
      $row[1] = $book;
      $row[2] = $chapter;
      $row[3] = $verse;
      $row[4] = $content;
      $result[] = $row;
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

</body>
</html>