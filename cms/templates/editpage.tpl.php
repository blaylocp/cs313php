<?php
// Start the Session
session_start();

// Get Session Variables
 $loginInfo = $_SESSION['LoginInfo'];
 $navLinks = $_SESSION['navigationLinks'];
 $pageData = $_SESSION['editPage'];
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
              echo ' | ';
              echo '<a href="/cms?action=RegisterPage">Register</a>';
            } else{
              echo '<a href="/cms?action=Logout&amp;pageCode='. $webpageData['pageId'] .'">Logout</a>';
            }
      ?>
      <div class="row">
        <div class="col-sm-2 logo header-section-1">
          <img src="/cms/images/logo.png" />
        </div>
        <div class="col-sm-4 page-title-wrapper header-section-2">
          <h1 class="page-title-<?php echo $webpageData['pageTitle']; ?>">Edit Page</h1>
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
      <form method='post' action='/cms/index.php' class="col-sm-8 col-sm-offset-2">
        <label>Page Title</label><br>
        <input type="text" name="pageTitle" value="<?php echo $pageData['pageTitle']; ?>" /><br>
        <label>Page Image</label><br>
        <input type="text" name="pageImage" value="<?php echo $pageData['pageImage']; ?>" /><br>
        <label>Page Text</label><br>
        <textarea name="pageText" rows="20" cols="100"><?php echo $pageData['pageText']; ?></textarea><br>
        <input type="hidden" name="pageId" value="<?php echo $pageData['pageId']; ?>" />
        <input type="submit" name="action" value="Update Page" />
      </form>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
