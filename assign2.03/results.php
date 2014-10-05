<?php
  session_start();

  $programming = $_SESSION['programmingResults'];
  $os = $_SESSION['osResults'];
  $assignment = $_SESSION['assignResults'];
  $mysql = $_SESSION['mysqlResults'];
  $sum = $_SESSION['sum'];

  if(!isset($programming)
   || !isset($os)
   || !isset($assignment)
   || !isset($mysql)
   || !isset($sum)){
    header("Location: process.php?action=getResults");
  }

?>
<!DOCTYPE HTML>
<html>
  <?php include "../modules/head.php" ?>
  <body class="survey">
    <div class="body-wrapper">
      <header class="row">
        <img src="../images/survey2.png" alt="logo" title="logo" />
      </header>
      <div class="main-content">
        <div class="row">

          <div class="programming">
            <h2>Most popular programming Language</h2>
            <table>
              <?php
                foreach($programming as $pro){
                  echo '<tr>' .
                    '<td><label>' . $pro[0] . '</label></td>' .
                    '<td>' . number_format($pro[1]/$sum * 100, 2 ) . '%' . '</td>' .
                    '</tr>';
                }
                ?>
            </table>
          </div>

          <div class="os">
            <h2>Most popular OS</h2>
            <table>
              <?php
                foreach($os as $o){
                  echo '<tr>' .
                    '<td><label>' . $o[0] . '</label></td>' .
                    '<td>' . number_format($o[1]/$sum * 100, 2 ) . '%' . '</td>' .
                    '</tr>';
                }
                ?>
            </table>
          </div>

          <div class="assignment">
            <h2>I easily understood the group assignment</h2>
            <table>
              <?php
                foreach($assignment as $assign){
                  echo '<tr>' .
                    '<td><label>' . $assign[0] . '</label></td>' .
                    '<td>' . number_format($assign[1]/$sum * 100, 2 ) . '%' . '</td>' .
                    '</tr>';
                }
                ?>
            </table>
          </div>

          <div class="Mysql">
            <h2>Understanding of Mysql</h2>
            <table>
              <?php
                foreach($mysql as $my){
                  echo '<tr>' .
                    '<td><label>' . $my[0] . '</label></td>' .
                    '<td>' . number_format($my[1]/$sum * 100, 2 ) . '%' . '</td>' .
                    '</tr>';
                }
                ?>
            </table>
          </div>

          <nav>
            <?php if($_SESSION['taken'] == FALSE){
                echo '<a href="survey.php" title="See Results">Return to Survey</a>';
            }?>

            <a href="/" title="Return to Home Page">Return to Home Page</a>
          </nav>
        </div>
      <?php//  include "../modules/footer.php"?>
    </div>
  </body>
</html>
