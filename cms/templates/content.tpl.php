<div class="row">
  <div class="col-sm-4">
    <img src="<?php echo $webpageData['pageImage']; ?>"/>
  </div>
  <div class="col-sm-8">
    <p class="big-text"><?php echo $webpageData['pageText']; ?></p>
  </div>
  <div style="clear:both"></div>
  <div class="col-sm-12"><?php echo $webpageData['createdByFirstName'] . " " . $webpageData['createdByLastName'] . " | " . $webpageData['lastUpdated']; ?></div>
</div>
<div class="row comments-wrapper">
  <h2>Comments</h2>
  <hr>
  <?php
    if(empty($webpageComments)){
      echo "No Comments" . "<hr>";
    }
    else{
      foreach($webpageComments as $comment){
        echo "<div class='comment-id-" . $comment['commentId'] . "'>";
        echo "<p>" . $comment['comment'] . "</p>";
        echo "<div class='comment-details'><span class='comment-name'>"
        . $comment['commentName'] . "  |  </span><span class='comment-date'>".
        $comment['commentDate'] . "</div>";
        echo "</div><hr>";
      }
    }
  ?>
  <?php if(!empty($loginInfo)) : ?>
  <h2>Add a New Comment</h2>
  <form method="post" action='/cms/index.php'>
    <textarea name='comment'></textarea><br>
    <input type="hidden" name="userId" value="<?php echo $loginInfo['userId'] ?>"/>
    <input type="hidden" name="pageId" value="<?php echo $webpageData['pageId'] ?>"/>
    <input type='submit' name='action' value='addComment'/>
  </form>
  <?php endif; ?>
</div>
