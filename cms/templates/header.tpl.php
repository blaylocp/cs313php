<?php
//Start the Session;
session_start();

// Assign Session Varaible so that it is easier to use
$navLinks = $_SESSION['navigationLinks'];

?>
<header>
  <div class="row">
    <div class="col-sm-2 logo header-section-1">
      <img src="/cms/images/logo.png" />
    </div>
    <div class="col-sm-4 page-title-wrapper header-section-2">
      <h1 class="page-title-<?php echo $webpageData['pageTitle']; ?>">
        <?php
         echo $webpageData['pageTitle'];
         ?>
      </h1>
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
