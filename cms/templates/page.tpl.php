<?php
// Start the Session
session_start();

// Get Session Variables
$_SESSION['webpageData']

?>
<!DOCTYPE HTML>
<html>
  <head>
    <?php include 'head.tpl.php'; ?>
  </head>
  <body>
    <?php include 'header.tpl.php'; ?>
    <div class="main-content">
      <?php include 'content.tpl.php'; ?>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
