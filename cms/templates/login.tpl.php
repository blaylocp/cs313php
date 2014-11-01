<?php
// Start the Session
session_start();

// Get Session Variables
$webpageData = $_SESSION['webpageData'];
$webpageData['pageTitle'] = "Login";
$webpageComments = $_SESSION['webpageComments'];

?>
<!DOCTYPE HTML>
<html>
    <?php include 'head.tpl.php'; ?>
  <body id="pageId-<?php echo $webpageData['pageId'];?>"
    class="page-<?php echo $webpageData['pageId']; ?>
     page-name-<?php echo $webpageData['pageTitle'];?> body-wrapper login-form std-form">
    <?php include 'header.tpl.php'; ?>
    <div class="main-content">
      <form method="post" action='/cms/index.php' class="col-sm-6 col-sm-offset-3">
        <label>Username</label><br>
        <input type="text" name='username'/><br>
        <label>Password</label><br>
        <input type="password" name='password'/><br>
        <input type="submit" value="Login" name='action'/>
      </form>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
