<div class="mise-en-page">
  <div class="main-content">

    <div>
      <form action="mysql/r_tweet.php" method="post" class="create-post">
        <div class="tweet-input">
          <textarea name="txtTweet" id="txtTweet" placeholder="" maxlength="140"></textarea>
          <div class="result-box">

          </div>

          <div id="txtCountTweet">0 / 140</div>
        </div>
        <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION['USER']['id'] ?>">
        <button type="submit" id="publishPost">Publier</button>
      </form>
    </div>

    <div id="tweets">

    </div>
  </div>
  <script src="tweet/tweet.js"></script>
  <script src="autocompletion.js"></script>

</div>