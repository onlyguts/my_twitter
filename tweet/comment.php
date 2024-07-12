<?php
session_start();
include('../mysql/mysql.php');
include('../includes/path.php');
$id_tweet = isset($_GET['id_tweet']) ? $_GET['id_tweet'] : null;
$sql = $mysqlClient->prepare('SELECT u.at_user_name, u.profile_picture, t.id as id_tweet, t.content, t.time FROM tweet t JOIN user u ON u.id = t.id_user WHERE t.id = :id');
$sql->execute(["id" => $id_tweet]);
$tweet = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $mysqlClient->prepare('SELECT u.at_user_name, u.profile_picture, t.id as id_tweet, t.content, t.time FROM tweet t JOIN user u ON u.id = t.id_user WHERE t.id_response = :id ORDER BY t.id DESC');
$sql->execute(["id" => $id_tweet]);
$comments = $sql->fetchAll(PDO::FETCH_ASSOC);

$tweets = '
<div class="post">
   <div class="profilpost">
     <div class="photodeprofil">
     <a style="color:blue;" href="' . $path . 'Utilisateur/user_profil.php?id_user='  . $tweet['at_user_name'] . '"><img src="../' . $tweet['profile_picture'] . '" alt="photo de profil de ' . $tweet['username'] . '"> </a>
     </div>
     <div class="nomutilisateur">
       <a style="color:blue;" href="' . $path . 'Utilisateur/user_profil.php?id_user=' . $tweet['at_user_name'] . '">' . $tweet['at_user_name'] . '</a>
     </div>
   
     <div class="option">
       <span class="gifclick">
         <a href="Homepage.html">
           <img src="../assets/icons8-points-de-suspension-30.png" alt="Main Logo">
         </a>
       </span>
     </div>
   </div>
   <div class="borderpostcontent">
     <div class="postcontent">
       <p>' . $tweet['content'] . '</p>
     </div>
   </div>
   <p> ' . $tweet['time'] . ' </p>
   <span class="gifclick">
     <a href="tweet/retweet.php?id_tweet=' . $tweet['id_tweet'] . '">
       <img src="../assets/icons8-twitter-entoure.gif" alt="Main Logo">
     </a>
   </span>
   <span class="gifclick">
     <a href="Homepage.html">
       <img src="../assets/icons8-aimer.gif" alt="Main Logo">
     </a>
   </span>
   <span class="gifclick">
     <a href="tweet/comment.php?id_tweet=' . $tweet['id_tweet'] . '">
       <img src="../assets/icons8-bulle.gif" alt="Main Logo">
     </a>
   </span>
</div>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../style/accueil.css">
</head>

<body>
  <div class="marging">

    <?php include('../includes/left-sidebar.php') ?>
    <div class="mise-en-page">
      <div class="main-content">
        <?php echo $tweets ?>
        <form action="../mysql/r_sendcomment.php" method="post" class="create-post">
          <h2>Commenter</h2>

          <input type="text" name="comment" id="comment" id="postContent" rows="4" cols="50" placeholder="Quoi de neuf ?">
          <br>
          <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION['USER']['id'] ?>">
          <input type="hidden" name="id_tweet" id="id_tweet" value="<?php echo $tweet['id_tweet'] ?>">


          <button id="publishPost">Publier</button>
        </form>
        <?php
        foreach ($comments as $comment) :
        ?>
          <div class="post">
            <div class="profilpost">
              <div class="photodeprofil">
                <a style="color:blue;" href="<?php echo $path ?>Utilisateur/user_profil.php?id_user=<?php echo $comment['at_user_name'] ?>"><img src="../<?php echo $comment['profile_picture'] ?>" alt="photo de profil de <?php echo $comment['username'] ?>"> </a>
              </div>
              <div class="nomutilisateur">
                <a style="color:blue;" href="<?php echo $path ?>Utilisateur/user_profil.php?id_user=<?php echo $comment['at_user_name'] ?>'"><?php echo $comment['at_user_name'] ?></a>
              </div>
              <div class="option">
                <span class="gifclick">
                  <a href="Homepage.html">
                    <img src="../assets/icons8-points-de-suspension-30.png" alt="Main Logo">
                  </a>
                </span>
              </div>
            </div>
            <div class="borderpostcontent">
              <div class="postcontent">
                
                <p><?php echo $comment['content'] ?></p>
              </div>
            </div>
            <p><?php echo $comment['time'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php include('../includes/right-sidebar.php') ?>

  </div>

</body>

</html>