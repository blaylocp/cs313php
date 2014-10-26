<?php
// Start the Session
session_start();

// Get Session Variables
 $_SESSION['webpageData'];
 $loginInfo = $_SESSION['LoginInfo'];
 $navLinks = $_SESSION['navigationLinks'];
 $editPages = $_SESSION['editPages'];
 $editUsers = $_SESSION['editUsers'];

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
          <h1 class="page-title-<?php echo $webpageData['pageTitle']; ?>">Admin Page</h1>
        </div>
        <nav class="col-sm-6 header-section-3">
          <ul>
            <li><a href="/cms/">Home</a></li>
              <?php
                foreach($navLinks as $link){
                  echo "<li><a href='/cms?action=Webpage&amp;pageCode=$link[0]'>$link[1]</a></li>";
                }
              ?>
          </ul>
        </nav>
      </div>
    </header>
    <div class="main-content">
      <div class='editUsers'>
        <h2>Edit User</h2>
        <ul>
          <?php
            foreach($editUsers as $user){
              echo '<li>' . $user['userFullName'] . ' | ' . '<a href="/cms?action=EditUser&amp;editUserCode='. $user['userId'].'" >edit</a></li>';
            }
            ?>
        </ul>
      </div>
      <div class='editPages'>
        <h2>Edit Page</h2>
        <?php
          foreach($editPages as $page){
            echo '<li>' . $page[1] . ' | ' . '<a href="/cms?action=EditPage&amp;editPagecCode='. $page[0].'" >edit</a></li>';
          }
        ?>
      </div>
      <div class='insertPages'>
        <h2>Insert Page</h2>
        <form method='post' action='/cms/index.php'>
          <label>Page Title</label>
          <input type="text" name="pageTitle" /><br>
          <label>Page Image URL</label>
          <input type="text" name="pageImage" /><br>
          <label>Page Text</label><br>
          <textarea name="pageText" rows="20" cols="100"></textarea><br>
          <input type="hidden" name="userId" value="<?php echo $loginInfo['userId']; ?>" />
          <input type="submit" name="action" value="Insert Page" />
        </form>
      </div>
    </div>
    <?php include 'footer.tpl.php'; ?>
  </body>
</html>
