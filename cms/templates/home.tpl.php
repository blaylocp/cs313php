<?php
// Start the Session
session_start();

// Get Session Variables
$_SESSION['webpageData'];
$loginInfo = $_SESSION['LoginInfo'];
$navLinks = $_SESSION['navigationLinks'];

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
          <h1 class="page-title-<?php echo $webpageData['pageTitle']; ?>">Home Page</h1>
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
      <div class="row">
        <div class="col-sm-12">
          <p class="big-text">Hi welcome to the beta version of my CMS. I have been creating a simple cms for my Web Development class. The links are all created dynamically based on the pages in the database. Then the content from the database is pulled out and rendered using a standard template.</p><br>
          <p class="big-text">So the inital phase is done. The links are created dyanmically the pages are created dynamically.</p><br>
          <p class="big-text">The next phase will involve being able to add pages and update pages, and comments. I will be working on that next week.</p><br>
        </div>
        <div style="clear:both"></div>
      </div>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
