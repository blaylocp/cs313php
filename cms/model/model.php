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
