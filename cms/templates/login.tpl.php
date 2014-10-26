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
      <form method="post" action='/cms/index.php'>
        <label>Username</label>
        <input type="text" name='username'/>
        <label>Password</label>
        <input type="password" name='password'/>
        <input type="submit" value="Login" name='action'/>
      </form>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
