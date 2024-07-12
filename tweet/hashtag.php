<?php
include('../mysql/mysql.php');

$sql = $mysqlClient->prepare("SELECT u.*, t.content, t.id as tweet_id, t.time, t.id_quoted_tweet  FROM tweet t JOIN user u ON u.id = t.id_user WHERE t.content LIKE CONCAT('%', '#', :hashtag, '%') ORDER BY t.time DESC");
$sql->execute([
    'hashtag' => $_GET['hashtag'],
]);
$hashtag = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $mysqlClient->prepare("SELECT hl.hashtag, COUNT(*) as count FROM tweet t  JOIN hashtag_list hl ON t.content LIKE CONCAT('%', '#', :hashtag, '%') GROUP BY hl.hashtag ORDER BY count DESC LIMIT 10");
$sql->execute([
    'hashtag' => $_GET['hashtag'],
]);
$hashtag2 = $sql->fetch(PDO::FETCH_ASSOC);
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
    <?php include('../includes/left-sidebar.php');
    ?>
    <div class="mise-en-page">
       
        <div class="main-content">
            <h1> <?php echo $_GET['hashtag'] . " Tweet(s) : " . $hashtag2['count'] ?></h1>
            <?php foreach ($hashtag as $tweet) : ?>

                <div class="post">
               
                    <div class="profilpost">
                        <div class="photodeprofil">
                            <img src="<?php echo $path . $tweet['profile_picture'] ?>" alt="photodeprofil">
                        </div>
                        <div class="infoprofilontwit">
                            <div class="nomutilisateur">
                                <a><?php echo $tweet['username'] ?></a>
                            </div>
                            <div class="pseudo">
                                <a><?php echo $tweet['at_user_name'] ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="borderpostcontent">
                                <div class="postcontent">
                                    <p><?php echo $tweet['content'] ?>
                                    </p>
                                </div>

                            </div>
                    <p><?php echo $tweet['time'] ?></p>
                    <div class="smalllink">
                        <span class="gifclick">
                            <a href="../tweet/retweet.php?id_tweet=<?php echo $tweet['tweet_id'] ?>">
                                <img src="../assets/rt.png" alt="Main Logo">
                                <div class="nombredeRT">

                                </div>
                            </a>
                        </span>

                        <span class="gifclick">
                            <a href="../tweet/comment.php?id_tweet=<?php echo $tweet['tweet_id'] ?>">
                                <img src="../assets/comment.png" alt="Main Logo">
                                <div class="nombredecom">

                                </div>
                            </a>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    include('../includes/right-sidebar.php');
    ?>

</body>

</html>