<?php
// Start the Session
session_start();

// Get Session Variables
$webpageData = $_SESSION['webpageData'];
$webpageComments = $_SESSION['webpageComments'];

?>
<!DOCTYPE HTML>
<html>
    <?php include 'head.tpl.php'; ?>
  <body id="pageId-<?php echo $webpageData['pageId'];?>"
    class="page-<?php echo $webpageData['pageId']; ?>
     page-name-<?php echo $webpageData['pageTitle'];?> body-wrapper">
    <?php include 'header.tpl.php'; ?>
    <div class="main-content">
      <?php include 'content.tpl.php'; ?>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
