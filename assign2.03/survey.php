<?php
session_start();
 $errors = $_SESSION['errors'];
 $programming = $_SESSION['programming'];
 $os = $_SESSION['os'];
 $assignment = $_SESSION['assignment'];
 $mysqlQuestion = $_SESSION['mysql'];

 if($_SESSION['taken'] == true){
   header("Location: results.php");
 }

?>
<!DOCTYPE HTML>
<html>
  <?php include "../modules/head.php" ?>
  <body class="survey">
    <div class="body-wrapper">
      <header class="row">
        <img src="../images/survey.png" alt="logo" title="logo" />
      </header>
      <div class="main-content">
        <div class="row">
          <form name="Class Survey" action="process.php" method="post">
            <ul class="Error">
              <?php
              foreach($errors as $error){
                echo '<li>' . $error . '</li>';
              }
              ?>
            </ul>
            <div class="input-group">
              <label>What is you favorite programming language</label><br>
              <span class="survey-input"><input type="radio" name="programming" value="php"    <?php if (isset($programming) && $programming=="php") echo "checked"; ?>/>php</span>
              <span class="survey-input"><input type="radio" name="programming" value="c++"    <?php if (isset($programming) && $programming=="c++") echo "checked"; ?>/>c++</span>
              <span class="survey-input"><input type="radio" name="programming" value="java"   <?php if (isset($programming) && $programming=="java") echo "checked"; ?>/>java</span>
              <span class="survey-input"><input type="radio" name="programming" value="python" <?php if (isset($programming) && $programming=="python") echo "checked"; ?>/>python</span>
              <span class="survey-input"><input type="radio" name="programming" value="ruby"   <?php if (isset($programming) && $programming=="ruby") echo "checked"; ?>/>ruby</span>
              <span class="survey-input"><input type="radio" name="programming" value="JavaScript" <?php if (isset($programming) && $programming=="JavaScript") echo "checked"; ?>/>javaScript</span>
              <span class="survey-input"><input type="radio" name="programming" value="other"  <?php if (isset($programming) && $programming=="other") echo "checked"; ?>/>Other</span>
            </div>
            <div class="input-group">
              <label>What Operating System do you use?</label><br>
              <span class="survey-input"><input type="radio" name="os" value="Mac" <?php if (isset($os) && $os=="Mac") echo "checked"; ?>/>Mac</span>
              <span class="survey-input"><input type="radio" name="os" value="Windows" <?php if (isset($os) && $os=="Windows") echo "checked"; ?>/>Windows</span>
              <span class="survey-input"><input type="radio" name="os" value="Linux" <?php if (isset($os) && $os=="Linux") echo "checked"; ?>/>Linux</span>
              <span class="survey-input"><input type="radio" name="os" value="Other" <?php if (isset($os) && $os=="Other") echo "checked"; ?>/>Other</span>
            </div>
            <div class="input-group">
              <label>I easily understood the group assignment</label><br>
              <span class="survey-input"><input type="radio" name="assignment" value="Strongly Agree" <?php if (isset($assignment) && $assignment=="Strongly Agree") echo "checked"; ?>/>Strongly Agree</span>
              <span class="survey-input"><input type="radio" name="assignment" value="Agree" <?php if (isset($assignment) && $assignment=="Agree") echo "checked"; ?>/>Agree</span>
              <span class="survey-input"><input type="radio" name="assignment" value="Disagree" <?php if (isset($assignment) && $assignment=="Disagree") echo "checked"; ?>/>Disagree</span>
              <span class="survey-input"><input type="radio" name="assignment" value="Strongly Disagree" <?php if (isset($assignment) && $assignment=="Strongly Disagree") echo "checked"; ?>/>Strongly Disagree</span>
            </div>
            <div class="input-group">
              <label>I have a solid foundation of mysql</label><br>
              <span class="survey-input"><input type="radio" name="mysql" value="Strongly Agree" <?php if (isset($mysqlQuestion) && $mysqlQuestion=="Strongly Agree") echo "checked"; ?>/>Strongly Agree</span>
              <span class="survey-input"><input type="radio" name="mysql" value="Agree" <?php if (isset($mysqlQuestion) && $mysqlQuestion=="Strongly Agree") echo "checked"; ?>/>Agree</span>
              <span class="survey-input"><input type="radio" name="mysql" value="Disagree" <?php if (isset($mysqlQuestion) && $mysqlQuestion=="Strongly Agree") echo "checked"; ?>/>Disagree</span>
              <span class="survey-input"><input type="radio" name="mysql" value="Strongly Disagree" <?php if (isset($mysqlQuestion) && $mysqlQuestion=="Strongly Agree") echo "checked"; ?>/>Strongly Disagree</span>
            </div>
            <div class="survey-submit">
              <input type="submit" name="action" value="Submit" />
            </div>
          </form>
          <nav>
            <a href="process.php?action=getResults" title="See Results">See Results</a>
            <a href="/" title="Return to Home Page">Return to Home Page</a>
          </nav>
        </div>
      <?php//  include "../modules/footer.php"?>
    </div>
  </body>
</html>
