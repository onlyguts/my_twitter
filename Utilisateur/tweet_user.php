<?php
$sql = $mysqlClient->prepare('SELECT u.*, t.content, t.id as tweet_id, t.time, t.id_quoted_tweet FROM tweet t JOIN user u ON u.id = t.id_user WHERE t.id_user = :id AND t.id_response IS NULL ORDER BY t.id DESC');
$sql->execute([
    "id" => $user['id'],
]);
$tweets = $sql->fetchAll(PDO::FETCH_ASSOC);


?>

<section class="mytweets">
    <?php foreach ($tweets as $tweet) : ?>

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
                    <?php
                    $sql = $mysqlClient->prepare('SELECT u.*, t.content, t.time, t.id as tweet_id FROM user u JOIN tweet t ON t.id = :id WHERE u.id = t.id_user');
                    $sql->execute([
                        "id" => $tweet['id_quoted_tweet'],
                    ]);
                    $retweets = $sql->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <p><?php echo $tweet['content'] ?>
                        <?php if ($tweet['id_quoted_tweet'] != null) : ?>
                    <p><a href="../Utilisateur/user_profil.php?id_user=<?php echo $tweet['at_user_name'] ?>" style="color:blue"> <?php echo $tweet['at_user_name'] ?> </a>a retweeté un tweet de <a href="../Utilisateur/user_profil.php?id_user=<?php echo $retweets['at_user_name'] ?>" style="color:blue"> <?php echo $retweets['at_user_name'] ?> </a></p>


                    <a href="../tweet/comment.php?id_tweet=<?php echo $retweets['tweet_id'] ?>">
                        <div class="post">

                            <div class="profilpost">
                                <div class="photodeprofil">
                                    <img src="<?php echo $path . $retweets['profile_picture'] ?>" alt="photodeprofil">
                                </div>
                                <div class="infoprofilontwit">
                                    <div class="nomutilisateur">
                                        <a><?php echo $retweets['username'] ?></a>
                                    </div>
                                    <div class="pseudo">
                                        <a><?php echo $retweets['at_user_name'] ?></a>
                                    </div>
                                </div>
                            </div>

                            <div class="borderpostcontent">
                                <div class="postcontent">
                                    <p><?php echo $retweets['content'] ?>
                                    </p>
                                </div>

                            </div>
                            <p><?php echo $retweets['time'] ?></p>

                        </div>
                    </a>
                <?php endif; ?>
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
</section>