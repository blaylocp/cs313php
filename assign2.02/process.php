<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $major = $_POST['major'];
      $visited = $_POST['visited'];
      $comments = $_POST['comments'];
  }

?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Assignment 2.02 Processed</title>
  </head>
  <body>
    <label>Username: </label><span><?php echo $name; ?></span><br>
    <label>Email: </label><span><a href="mailto:<?php echo $email?>?Subject=Hello%20again" target="_top"><?php echo $email ?></a><br>
    <label>Major: </label><span><?php echo $major ?></span><br>
    <label>Places Visited</label>
    <ul>
    <?php
      foreach($visited as $value){
        echo "<li>$value</li>";
      }
    ?>
    </ul>
    <label>Comments</label>
    <p><?php echo $comments ?></p>
  </body>
</html>
