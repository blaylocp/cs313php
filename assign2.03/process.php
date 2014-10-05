<?php
  //Start Session
  session_start();
  //Get Connection Object
  if(file_exists('connection.php')){
    require('connection.php');
  }
  else{
    echo 'Bad DB Connection';
  }
  //Create Error Array
  $errors = array();

  //Set Action
  if($_GET['action']){
    $action = $_GET['action'];
  } elseif ($_POST['action']){
    $action = $_POST['action'];
  }

  //Create the results page
  if($action == 'getResults'){
    echo "outer";
    displayResults();
  }

  //submit the survey
  if($action == 'Submit'){

    if(empty($_POST['programming'])){
      $errors[] = "Question 1 is Required";
    }
    else{
      $programming = $_POST['programming'];
    }

    if(empty($_POST['os'])){
      $errors[] = "Question 2 is Required";
    }
    else{
      $os = $_POST['os'];
    }

    if(empty($_POST['assignment'])){
      $errors[] = "Question 3 is Required";
    }
    else{
      $assignment = $_POST['assignment'];
    }

    if(empty($_POST['mysql'])){
      $errors[] = "Question 4 is Required";
    }
    else{
      $mysqlQuestion = $_POST['mysql'];
    }

  if(!empty($errors)){
    $_SESSION['errors'] = $errors;
    $_SESSION['programming'] = $programming;
    $_SESSION['os'] = $os;
    $_SESSION['assignment'] = $assignment;
    $_SESSION['mysql'] = $mysqlQuestion;
    header("Location: survey.php");
  }
  else{
    $result = insertResults($programming, $os, $assignment, $mysqlQuestion);
    if($result == 0){
      echo 'Trouble Inserting Data'; die;
    }
    else{
      $_SESSION['taken'] = true;
      displayResults();
    }
  }
 }

//This function creates the results page
function displayResults(){
  echo $action . "inner"; die;
  //get variables
  $questionsResults = getQuestion();
  $sum = getSum();

  //Programming values
  $php = getPhp();
  $c = getC();
  $java = getJava();
  $js = getJS();
  $ruby = getRuby();
  $python = getPython();
  $other = getOther();

  //os values
  $mac = getMac();
  $windows = getWindows();
  $linux = getLinux();
  $otherOs = getOtherOs();

  //Assignment values
  $AssignSA = getAssignStrong();
  $AssignA = getAssignAgree();
  $AssignDA = getAssignDisagree();
  $AssignSDA = getAssignStrongDA();

  //Mysql values
  $mysqlSA = getMysqlStrong();
  $mysqlA = getMysqlAgree();
  $mysqlDA = getMysqlDisagree();
  $mysqlSDA = getMysqlStrongDA();

  //Session for programming table results.php
  $_SESSION['programmingResults'] = array(
    array('php',$php),
    array('c++',$c),
    array('Java',$java),
    array('JavaScript',$js),
    array('Ruby',$ruby),
    array('Python', $python),
    array('Other',$other)
  );

  //Session for os table results.php
  $_SESSION['osResults'] = array(
    array('Mac',$mac),
    array('Windows',$windows),
    array('Linux',$linux),
    array('Other', $otherOs)
  );

  //Session for assignment table results.php
  $_SESSION['assignResults'] = array(
    array('Strongly Agree', $AssignSA),
    array('Agree',$AssignA),
    array('Disagree', $AssignDA),
    array('Strongly Disagree',$AssignSDA)
  );

  //Session for mysql table results.php
  $_SESSION['mysqlResults'] = array(
    array('Strongly Agree', $mysqlSA),
    array('Agree',$mysqlA),
    array('Disagree', $mysqlDA),
    array('Strongly Disagree',$mysqlSDA)
  );

  //Sum of rows results.php
  $_SESSION['sum'] = $sum;

  //Go to results.php
  header("Location: results.php");
}

// insert results into table
function insertResults($programming, $os, $assignment, $mysqlQuestion){

    global $connection;

    $connection->autocommit(FALSE);
    $flag = TRUE;

    $sql = 'INSERT INTO survey_results(question_one, question_two, question_three, question_four) VALUES(?,?,?,?)';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_param('ssss', $programming, $os, $assignment, $mysqlQuestion);
      $stmt->execute();
      $result = $connection->affected_rows;
      $client_id = $connection->insert_id;
      $stmt->close();
    }

    if($result == FLASE || $client_id == FLASE){
      $flag == FLASE;
    }

    if($flag == TRUE){
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

//Get table values
function getQuestion(){
    global $connection;

    $sql = 'SELECT * FROM survey_results';

    if($stmt = $connection->prepare($sql)){
        $stmt->bind_result($id,$question1,$question2,$question3,$question4);
        $results = array();
        $row = array();
        $stmt->execute();
        while($stmt->fetch()){
          $row[0] = $id;
          $row[1] = $question1;
          $row[2] = $question2;
          $row[3] = $question3;
          $row[4] = $question4;
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

//Sum of rows
function getSum(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming php rows
function getPhp(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="php"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming java rows
function getJava(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="java"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming c++ rows
function getC(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="c++"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming python rows
function getPython(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="python"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming ruby rows
function getRuby(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="ruby"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming javascript rows
function getJS(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="JavaScript"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Programming other rows
function getOther(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_one="other"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

// OS Mac rows
function getMac(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_two="mac"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

// OS Windows rows
function getWindows(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_two="windows"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

// OS linux rows
function getLinux(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_two="linux"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

// OS other rows
function getOtherOs(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_two="other"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Assignment rows strongly agree
function getAssignStrong(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_three="Strongly Agree"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Assignment rows agree
function getAssignAgree(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_three="Agree"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Assignment rows disagree
function getAssignDisagree(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_three="Disagree"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//Assignment rows strongly disagree
function getAssignStrongDA(){
    global $connection;

    $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_three="Strongly Disagree"';

    if($stmt = $connection->prepare($sql)){
      $stmt->bind_result($sum);
      $stmt->execute();
      $stmt->fetch();
    }

    $stmt->close();
    return $sum;
}

//mysql rows strongly agree
function getMysqlStrong(){
  global $connection;

  $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_four="Strongly Agree"';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_result($sum);
    $stmt->execute();
    $stmt->fetch();
  }

  $stmt->close();
  return $sum;
}

//mysql rows agree
function getMysqlAgree(){
  global $connection;

  $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_four="Agree"';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_result($sum);
    $stmt->execute();
    $stmt->fetch();
  }

  $stmt->close();
  return $sum;
}

//mysql rows disagree
function getMysqlDisagree(){
  global $connection;

  $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_four="Disagree"';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_result($sum);
    $stmt->execute();
    $stmt->fetch();
  }

  $stmt->close();
  return $sum;
}

//mysql rows strongly disagree
function getMysqlStrongDA(){
  global $connection;

  $sql = 'SELECT COUNT(*) FROM survey_results WHERE question_four="Strongly Disagree"';

  if($stmt = $connection->prepare($sql)){
    $stmt->bind_result($sum);
    $stmt->execute();
    $stmt->fetch();
  }

  $stmt->close();
  return $sum;
}
