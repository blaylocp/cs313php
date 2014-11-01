<?php
// Start the Session
session_start();

// Get Session Variables
 $loginInfo = $_SESSION['LoginInfo'];
 $navLinks = $_SESSION['navigationLinks'];
 $userData = $_SESSION['editUser'];
 $registerError = $_SESSION['registerError'];
?>
<!DOCTYPE HTML>
<html>
  <head>
    <?php include 'head.tpl.php'; ?>
  </head>
  <body class="home body-wrapper std-form">
    <header>
      <?php if(empty($loginInfo)){
              echo '<a href="/cms?action=LoginPage&amp;pageCode='. $webpageData['pageId'] .'">Login</a>';
            } else{
              echo '<a href="/cms?action=Logout&amp;pageCode='. $webpageData['pageId'] .'">Logout</a>';
            }
      ?>
      <div class="row">
        <div class="col-sm-2 logo header-section-1">
          <img src="/cms/images/logo.png" />
        </div>
        <div class="col-sm-4 page-title-wrapper header-section-2">
          <h1 class="page-title-<?php echo $webpageData['pageTitle']; ?>">Register</h1>
        </div>
        <nav class="col-sm-6 header-section-3">
          <ul>
            <li><a href="/cms/">Home</a></li>
              <?php
                foreach($navLinks as $link){
                  echo "<li><a href='/cms?action=Webpage&amp;pageCode=$link[0]'>$link[1]</a></li>";
                }
                if(!empty($loginInfo) && $loginInfo['RoleValue'] == 40){
                  echo "<li><a href='/cms?action=Admin'>Admin</a></li>";
                }
              ?>
          </ul>
        </nav>
      </div>
    </header>
    <div class="main-content">
      <form method='post' action='/cms/index.php' class="col-sm-6 col-sm-offset-3">
        <span><?php echo $registerError; ?></span><br>
        <label>First Name</label><br>
        <input type="text" name="firstName" required/><br>
        <label>Middle Intial</label><br>
        <input type="text" name="middleI"  /><br>
        <label>Last Name</label><br>
        <input type="text" name="lastName" required/><br>
        <label>Username</label><br>
        <input type="text" name="username" required/><br>
        <label>Password</label><br>
        <input type="password" name="password" required/><br>
        <input type="submit" name="action" value="Register" />
      </form>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
