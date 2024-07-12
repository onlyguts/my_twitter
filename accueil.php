<?php

session_start();
if (!isset($_SESSION['USER'])) {
  header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tweet academie</title>
  <link rel="stylesheet" href="style/accueil.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
    /* $(document).ready(function() {
      function fetchTweets() {
        $.ajax({
          url: 'mysql/fetch_tweets.php',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            //récup tous les tweets  : [{id: 12, text: "tettete"}, {id: 14}]
            $('#tweets').empty();
            $.each(data, function(rt, key, tweet) {
                rt.push = (tweet); 
            })
          }
        })
      };
      if (tweet.id_quoted_tweet != null) {
        // foreach du tableau tweets : pour chaque id tu fais request ajax
        const rtResponse = $.ajax({
          url: `mysql/fetch_retweets.php?id_quoted_tweet=` + tweet.id_quoted_tweet + ``,
          type: 'GET',
          data: {
            id_quoted_tweet: tweet.id_quoted_tweet
          },
          dataType: 'json',
          success: function(json) {
            // rt.push(json[0].id)
            // rt = json[0].id
          },
        });
      }

      console.log(rt);
      fetchTweets();
      setInterval(fetchTweets, 5000);
    }); */
    $(document).ready(async function() {
      var tweet = [];
      var tweet_count = [];
      var body;
      var finish_tweets_at_user_name;
      await fetch(tweet)

      async function fetch(tweet) {
        var tweet = [];
        async function fetchTweets(tweet) {
          await $.ajax({
            url: 'mysql/fetch_tweets.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $('#tweets').empty();
              $.each(data, function(key, tweete) {
                tweet.push(tweete);
              });
      
            }
          });

        }

        await fetchTweets(tweet);

        for (let index = 0; index < tweet.length; index++) {

          let tweets = tweet[index];
          var finish_tweets_username = tweets.username;

          console.log(tweets)

          if (tweets.id_quoted_tweet != null) {
            await fetchRetweet(tweets, function(retweet) {

              // body =  " | ID tweet :"  + tweets.tweet_id + " | ID rt " + tweets.id_quoted_tweet  + " | Content : " +  retweet.rt_content +"<br>";
              finish_tweets_at_user_name = tweets.at_user_name;
              finish_tweets_tweet_id = tweets.tweet_id;
              finish_tweets_profile_picture = tweets.profile_picture
              finish_tweets_content = tweets.at_user_name + " a retweeté un tweet de " + retweet.at_user_name;
              finish_tweets_time = tweets.time;

              finish_tweets_rtcontent = `
                                <a href="tweet/comment.php?id_tweet=`+retweet.tweet_id+`">
                                  <div class="repost">
                                   <div class="profilpost">
                                     <div class="photodeprofil">
                                     <img src="` + retweet.profile_picture + `" alt="photo de profil de ` + retweet.at_user_name + ` ">
                                     </div>
                                     <div class="nomutilisateur">
                                       <a style="color:blue;" href="Utilisateur/user_profil.php?id_user=` + retweet.at_user_name + `">` + retweet.at_user_name + `</a>
                                     </div>
                                     <div class="option">
                                   <span class="gifclick">
                                 
                                 </span>
                                   </div>
                                   </div>
                                   <div class="borderpostcontent">
                                   <div class="postcontent">
                                   <p >` + retweet.rt_content.replace(/@(\w+)/g, "<a style='color:blue' href='Utilisateur/user_profil.php?id_user=$1'>@$1</a>").replace(/#(\w+)/g, "<a style='color:black;   font-weight: bold;' href='tweet/hashtag.php?hashtag=$1'>#$1</a>") + `</p>                   
                                   </div>
                                 </div>
                                 <p class='timeProfil'>` + retweet.time + `</p>
                               </div>
                               </a>`
                               ;
            });
          } else {
            //body =  " | ID tweet : " + tweets.tweet_id + " | Content :" + tweets.content + "<br>";
            finish_tweets_at_user_name = tweets.at_user_name;
            finish_tweets_tweet_id = tweets.tweet_id;
            finish_tweets_profile_picture = tweets.profile_picture;
            finish_tweets_content = tweets.content;
            finish_tweets_rtcontent = "";
            finish_tweets_time = tweets.time;
          }
          body = `
          <div class="post">
            <div class="profilpost">
              <div class="photodeprofil">
              <a style="color:blue;" href="Utilisateur/user_profil.php?id_user=` + finish_tweets_at_user_name + `"><img src="` + finish_tweets_profile_picture + `" alt="photo de profil de ` + finish_tweets_at_user_name + ` "> </a>
              </div>
          <div class="infoprofilontwit">
            <div class="nomutilisateur">
            <a>` + finish_tweets_username + `</a>
            </div>
            <div class="pseudo">
            <a style="color:blue;" href="Utilisateur/user_profil.php?id_user=` + finish_tweets_at_user_name + `">` + finish_tweets_at_user_name + `</a>
            </div>
          </div>
          <div class="option">
            <span class="gifclick">
            </span>
          </div>
        </div>
        <div class="borderpostcontent">
          <div class="postcontent">
          <p class='rtTxt'>` + finish_tweets_content.replace(/@(\w+)/g, "<a style='color:blue' href='Utilisateur/user_profil.php?id_user=@$1'>@$1</a>").replace(/#(\w+)/g, "<a style='color:black;   font-weight: bold;' href='tweet/hashtag.php?hashtag=$1'>#$1</a>") + `</p>
                                      <p>` + finish_tweets_rtcontent + ` </p>
          </div>
        </div>
        <p class='timeProfil'>` + finish_tweets_time + `</p>
        <div class="smalllink">
          <span class="gifclick">
          <a href="tweet/retweet.php?id_tweet=` + finish_tweets_tweet_id + `">
              <img src="assets/rt.png" alt="Main Logo">
              <div class="nombredeRT">
                <p></p>
              </div>
            </a>
          </span>
       
          <span class="gifclick">
          <a href="tweet/comment.php?id_tweet=` + finish_tweets_tweet_id + `">
              <img src="assets/comment.png" alt="Main Logo">
              <div class="nombredecom">
                <p></p>
              </div>
            </a>
        </div>
      </div>`;

          $('#tweets').append(body);
        }

        async function fetchRetweet(tweets, callback) {
          await $.ajax({
            url: "mysql/fetch_retweets.php",
            type: 'GET',
            data: {
              id_quoted_tweet: tweets.id_quoted_tweet
            },
            dataType: 'json',
            success: function(json) {
              callback(json[0]);
            }
          });
        }
      }

      tweet = []
      setInterval(fetch, 65000, tweet);
    });


    //fetchRetweets();

    /*  console.log(rt);
               // console.log(rt[0]);
               let body = `
                                   <div class="post">
                                   <div class="profilpost">
                                     <div class="photodeprofil">
                                     <a style="color:blue;" href="Utilisateur/user_profil.php?id_user=` + tweet.at_user_name + `"><img src="` + tweet.profile_picture + `" alt="photo de profil de ` + tweet.at_user_name + ` "> </a>
                                     </div>
                                     <div class="nomutilisateur">
                                       <a style="color:blue;" href="Utilisateur/user_profil.php?id_user=` + tweet.at_user_name + `">` + tweet.at_user_name + `</a>
                                     </div>
                                     <div class="option">
                                   <span class="gifclick">
                                   <a href="Homepage.html">
                                     <img src="assets/icons8-points-de-suspension-30.png" alt="Main Logo">
                                   </a>
                                 </span>
                                   </div>
                                   </div>
                                   <div class="borderpostcontent">
                                   <div class="postcontent">
                                     <p>` + tweet.content.replace(/@(\w+)/g, "<a href='Utilisateur/user_profil.php?id_user=@$1'>@$1</a>") + `</p>
                                     <p>    ` + rt + ` </p>
                                   </div>
                                 </div>
                                 <span class="gifclick">
                                   <a href="tweet/retweet.php?id_tweet=` + tweet.tweet_id + `">
                                     <img src="assets/icons8-twitter-entoure.gif" alt="Main Logo">
                                   </a>
                                 </span>
                                 <span class="gifclick">
                                   <a href="Homepage.html">
                                     <img src="assets/icons8-aimer.gif" alt="Main Logo">
                                   </a>
                                 </span>
                                 <span class="gifclick">
                                   <a href="Homepage.html">
                                     <img src="assets/icons8-bulle.gif" alt="Main Logo">
                                   </a>
                                 </span>
                               </div>
                               `;
                 $('#tweets').append(`` + body + ``);
             });
           }       
       }*/
  </script>
</head>

<body>

  <div class="marging">

    <?php include('mysql/mysql.php') ?>
    <?php include('includes/path.php') ?>
    <?php include('includes/left-sidebar.php') ?>
    <?php include('includes/main.php') ?>
    <?php include('includes/right-sidebar.php') ?>
 
  </div>

  <div>
    <button id="darkModeToggle">Dark Mode</button>
  </div>
  <script src="dark.js"></script>

</body>

</html>