<?php
// Start the Session
session_start();

// Get Session Variables
 $loginInfo = $_SESSION['LoginInfo'];
 $navLinks = $_SESSION['navigationLinks'];
 $userData = $_SESSION['editUser'];
?>
<!DOCTYPE HTML>
<html>
  <head>
    <?php include 'head.tpl.php'; ?>
  </head>
  <body class="home body-wrapper">
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
          <h1 class="page-title-<?php echo $webpageData['pageTitle']; ?>">Edit User</h1>
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
      <form method='post' action='/cms/index.php'>
        <label>First Name</label>
        <input type="text" name="firstName" value="<?php echo $userData['userFirst']; ?>" /><br>
        <label>Middle Intial</label>
        <input type="text" name="middleI" value="<?php echo $userData['userMiddle']; ?>" /><br>
        <label>Last Name</label>
        <input type="text" name="lastName" value="<?php echo $userData['userLast']; ?>" /><br>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $userData['username']; ?>" /><br>
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $userData['password']; ?>" /><br>
        <input type="hidden" name="userId" value="<?php echo $userData['userId']; ?>" />
        <input type="submit" name="action" value="Update User" />
      </form>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
