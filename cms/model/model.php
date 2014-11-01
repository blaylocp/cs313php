<?php
/***********************************************
 * Main Controller for the CMS
 ***********************************************/
// Include the connection
if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/cms/model/connection.php')){
  require_once($_SERVER['DOCUMENT_ROOT'] . '/cms/model/connection.php');
}
else{
  echo 'Could not connect to the Database'; die;
  include '/templates/error.tpl.php';
}

if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/cms/model/password.php')){
  require_once($_SERVER['DOCUMENT_ROOT'] . '/cms/model/password.php');
}
else{
  echo 'Could not connect to the PASSWORD SCRIPT'; die;
}

function getLinks(){
  global $connection;

  $sql = 'SELECT page_id, page_title FROM webpage';
  if($stmt = $connection->prepare($sql)){
    $stmt->bind_result($pageId, $pageName);
    $row = array();
    $result = array();
    $stmt->execute();
    while($stmt->fetch()){
      $row[0] = $pageId;
      $row[1] = $pageName;
      $result[] = $row;
    }
    $stmt->close();
    if(!empty($result)){
      return $result;
    } else{
      return 0;
    }

  } else{
    echo 'didn\'t connect'; die;
  }
}


function getUsers(){
  global $connection;

  $sql = 'SELECT user_id, user_first_name, user_last_name FROM user';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_result( $userId, $userFirst, $userLast);
    $result = array();
    $row = array();
    $stmt->execute();
    while($stmt->fetch()){
      $row['userId'] = $userId;
      $row['userFullName'] = $userFirst . " " . $userLast;
      $result[] = $row;
    }
  }
  $stmt->close();

  if(!empty($result)){
    return $result;
  }
  elseif(empty($result)) {
    return 0;
  }
  else{
    return -1;
  }
}


function getUsersData($userId){
  global $connection;

  $sql = 'SELECT u.user_id, u.user_first_name, u.user_middle_initial, u.user_last_name, u.username, u.password, r.role_name, r.role_value
          FROM user u INNER JOIN role r ON (u.role_id = r.role_id)
          WHERE user_id = ?';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('i', $userId);
    $stmt->bind_result( $userId, $userFirst, $userMiddle, $userLast, $username, $password, $roleName, $roleValue);
    $result = array();
    $stmt->execute();
    $stmt->fetch();
      $result['userId'] = $userId;
      $result['userFirst'] = $userFirst;
      $result['userMiddle'] = $userMiddle;
      $result['userLast'] = $userLast;
      $result['username'] = $username;
      $result['password'] = $password;
      $result['roleName'] = $roleName;
      $result['roleValue'] = $roleValue;
  }
  $stmt->close();

  if(!empty($result)){
    return $result;
  }
  elseif(empty($result)) {
    return 0;
  }
  else{
    return -1;
  }
}

function getWebpageData($pageCode){

  global $connection;

  $sql = 'SELECT w.page_id,
                 w.page_title,
                 w.page_image_url,
                 w.page_text,
                 w.last_update_date,
                 u.user_first_name,
                 u.user_last_name
                 FROM webpage w
                 INNER JOIN user u ON (w.user_id = u.user_id)
                 WHERE w.page_id = ?';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('i', $pageCode);
    $stmt->bind_result($pageId, $pageTitle, $pageImage, $pageText, $pageDate, $userFirstName, $userLastName);
    $stmt->execute();
    $stmt->fetch();
    $result = array("pageId"=>$pageId, "pageTitle"=> $pageTitle, "pageImage"=> $pageImage, "pageText" => $pageText, "lastUpdated" => $pageDate,"createdByFirstName" => $userFirstName,"createdByLastName" => $userLastName);
    $stmt->close();

    if(!empty($result)){
      return $result;
    } else{
      return 0;
    }
  }
}


function getCommentsWebpage($pageCode){

  global $connection;
  $sql = 'SELECT c.comment_id,
                 c.comment,
                 u.user_first_name,
                 u.user_last_name,
                 c.last_update_date,
                 w.page_id
          FROM comment c
          INNER JOIN user u ON ( c.user_id = u.user_id )
          INNER JOIN webpage w ON ( w.page_id = c.page_id )
          WHERE w.page_id = ?';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('i', $pageCode);
    $stmt->bind_result($commentId, $comment, $commentFirstName, $commentLastName,  $commentDate, $pageId );
    $row = array();
    $result = array();
    $stmt->execute();
    while($stmt->fetch()){
      $row['commentId'] = $commentId;
      $row['comment'] = $comment;
      $row['commentName'] = $commentFirstName . " " . $commentLastName;
      $row['commentDate'] = $commentDate;
      $row['commentPageId'] = $pageId;
      $result[] = $row;
    }
    $stmt->close();

    if(!empty($result)){
      return $result;
    } else{
      return 0;
    }
  }
}

function login($username, $password){
  global $connection;


  $sql = 'SELECT u.user_id, u.user_first_name, u.user_last_name, r.role_name, r.role_value, u.password
          FROM user u INNER JOIN role r ON (u.role_id = r.role_id) WHERE u.username = ?';

  if($stmt = $connection->prepare($sql)){

    $stmt->bind_param('s', $username);
    $stmt->bind_result( $userId, $userFirst, $userLast, $roleName, $roleValue, $hashedPasswordFromDB);
    $result = array();
    $stmt->execute();
    $stmt->fetch();
    $result['userId'] = $userId;
    $result['userFullName'] = $userFirst . " " . $userLast;
    $result['userRole'] = $roleName;
    $result['RoleValue'] = $roleValue;
  }
  $stmt->close();

  $verified = password_verify($password, $hashedPasswordFromDB);

  if(!empty($result) && $verified == 1){
    return $result;
  }
  elseif(empty($result) || $verified == 0) {
    return 0;
  }
  else{
    return -1;
  }
}


function addComment($userId,$pageId,$comment){
  global $connection;
  $connection->autocommit(FALSE);
  $flag = TRUE;

  $sql = 'INSERT INTO comment VALUES(null,?,?,1,UTC_DATE(),1, UTC_DATE(),?)';
  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('sii',$comment, $pageId, $userId);
    $stmt->execute();
    $result = $connection->affected_rows;
    $rowId = $connection->insert_id;
    $stmt->close();
  }

  if($result == FALSE || $rowId == FALSE){
    $flag = FALSE;
  }

  if($flag){
    $connection->commit;
    $connection->autocommit(TRUE);
    return 1;
  }
  else{
    $connection->rollback;
    $connection->autocommit(TRUE);
    return 0;
  }
}

function updatePage($id, $title, $image, $text){
  global $connection;
  $connection->autocommit(FALSE);
  $flag = TRUE;

  $sql = 'UPDATE webpage SET page_title=?, page_image_url=?, page_text=?, last_update_date=UTC_DATE() WHERE page_id=?';
  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('sssi', $title, $image, $text, $id);
    $stmt->execute();
    $result = $connection->affected_rows;
    $stmt->close();
  }
  if($result == FALSE){
    $flag = FALSE;
  }

  if($flag){
    $connection->commit;
    $connection->autocommit(TRUE);
    return 1;
  }
  else{
    $connection->rollback;
    $connection->autocommit(TRUE);
    return 0;
  }
}

function updateUser($firstName, $middleI, $lastName, $username, $password, $userId){
  global $connection;
  $connection->autocommit(FALSE);
  $flag = TRUE;
  $password = password_hash($password, PASSWORD_DEFAULT);

  $sql = 'UPDATE user SET user_first_name=?, user_middle_initial=?, user_last_name=?, username=?, password=?, last_update_date=UTC_DATE() WHERE user_id=?';
  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('sssssi', $firstName, $middleI, $lastName, $username, $password, $userId);
    $stmt->execute();
    $result = $connection->affected_rows;
    $stmt->close();
  }
  if($result == FALSE){
    $flag = FALSE;
  }

  if($flag){
    $connection->commit;
    $connection->autocommit(TRUE);
    return 1;
  }
  else{
    $connection->rollback;
    $connection->autocommit(TRUE);
    return 0;
  }
}

function insertPage($pageTitle, $pageImage, $pageText, $userId){
  global $connection;
  $connection->autocommit(FALSE);
  $flag = TRUE;

  $sql = 'INSERT INTO `webpage`(`page_id`, `page_title`, `page_image_url`, `page_text`, `create_by`, `creation_date`, `last_updated_by`, `last_update_date`, `user_id`) VALUES (null, ?, ?, ?, 1, UTC_DATE(), 1, UTC_DATE(), ?)';
  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('sssi',$pageTitle, $pageImage, $pageText, $userId);
    $stmt->execute();
    $result = $connection->affected_rows;
    $rowId = $connection->insert_id;
    $stmt->close();
  }

  if($result == FALSE || $rowId == FALSE){
    $flag = FALSE;
  }

  if($flag){
    $connection->commit;
    $connection->autocommit(TRUE);
    return 1;
  }
  else{
    $connection->rollback;
    $connection->autocommit(TRUE);
    return 0;
  }
}

function register($firstName, $middleI, $lastName, $username, $password){
  global $connection;
  $connection->autocommit(FALSE);
  $flag = TRUE;

  $password = password_hash($password, PASSWORD_DEFAULT);

  if(duplicateUser($username) == 0){


    $sql = 'INSERT INTO `user` VALUES (null,  ?, ?, ?, ?, ?, 1, UTC_DATE(), 1, UTC_DATE(), 2)';

    if($stmt = $connection->prepare($sql)){

      $stmt->bind_param('sssss', $firstName, $middleI, $lastName, $username, $password);
      $stmt->execute();
      $result = $connection->affected_rows;
      $rowId = $connection->insert_id;
      $stmt->close();
    }

    if($result == FALSE || $rowId == FALSE){
      $flag = FALSE;
    }

    if($flag){
      $connection->commit;
      $connection->autocommit(TRUE);
      return 1;
    }
    else{
      $connection->rollback;
      $connection->autocommit(TRUE);
      return 0;
    }
  }
  else{
    return -1;
  }
}

function duplicateUser($username){
  global $connection;

  $sql = 'SELECT u.user_id FROM user u WHERE u.username = ?';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_param('s', $username);
    $stmt->bind_result($userID);
    $stmt->execute();
    $stmt->fetch();
  }
  $stmt->close();
  if(!empty($userID)){
    return $userID;
  } else{
    return 0;
  }
}
