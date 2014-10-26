<?php
$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
$dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
$dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

function getTopics(){
  global $con;
  $sql = 'SELECT * FROM Topics';

  if($stmt = $con->prepare()){
      $stmt->bind_result($id, $name);
      $row = array();
      $result = array();
      $stmt->execute();
      while($stmt->fetch()){
        $row[0] = $id;
        $row[1] = $name;
        $result[] = $row;
      }
      $stmt->close();

      if(!empty($result)){
        return $result;
      } else{
        return 0 ;
      }
  }
}

function insertScripture($book,$chapter,$verse,$content,$topics){
  global $con;

  $con->autocommit(FALSE);
  $flag = TRUE;

  $sql = 'INSERT INTO SCRIPTURE VALUES(?,?,?,?)';
  if($stmt = $con->prepare()){
      $stmt->bind_param('siis', $book,$chapter,$verse,$content);
      $stmt->execute();
      $scriptureId = $stmt->result_id;
      $result = $con->affected_rows;
      $stmt->close();
  }

  if($result == FALSE ||$scriptureId == FALSE ){
    $flag = FALSE;
  }

  if($flag){
    $sql = ' INSERT INTO TopicsToScripture VALUES(?, ?)';

    if($stmt = $con->prepare()){
      foreach($topics as $row){
        $stmt->bind_param('ii', $row[0], $scriptureId);
      }
      $stmt->execute();
      $result2 = $con->affected_rows;
      $stmt->close();
    }
  }


  if($flag){
    $con->commit;
    $con->autocommit(TRUE);
    return 1;
  }
  else{
    $con->rollback;
    return 0; 
  }

}
