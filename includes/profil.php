<?php
session_start();



$sql = $mysqlClient->prepare('SELECT count(u.id) as count, u.username FROM user u JOIN follow f ON f.id_user = u.id WHERE u.id = :id');
$sql->execute([
    "id" => $user['id'],
]);
$follower = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $mysqlClient->prepare('SELECT count(u.id) as count, u.username FROM user u JOIN follow f ON f.id_follow = u.id WHERE u.id = :id');
$sql->execute([
    "id" => $user['id'],
]);
$following = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $mysqlClient->prepare('SELECT u.* FROM user u JOIN follow f ON f.id_user = :id WHERE f.id_follow = u.id');
$sql->execute([
    "id" => $user['id'],
]);
$followingUser = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql = $mysqlClient->prepare('SELECT u.* FROM user u JOIN follow f ON f.id_follow = :id WHERE f.id_user = u.id');
$sql->execute([
    "id" => $user['id'],
]);
$followerUser = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql = $mysqlClient->prepare('SELECT f.* FROM follow f WHERE f.id_user = :id_user AND f.id_follow = :id_follow');
$sql->execute([
    "id_user" => $_SESSION['USER']['id'],
    "id_follow" => $user['id'],
]);
$uFollow = $sql->fetch(PDO::FETCH_ASSOC);


?>



<div class="mise-en-page">
    <div class="main-content">
        <div class="container">
            <section class="twitterprofile">
                <div class="headerprofileimage">
                    <?php if (!isset($user['id'])) {
                        echo "CET UTILISATEUR N'EXISTE PAS !";
                        return;
                    }
                    ?>
                    <img src="<?php echo $path . $user['banner'] ?>" id="headerimage">
                    <img src="<?php echo $path . $user['profile_picture'] ?>" id="profilepic">
                    <?php if ($_SESSION['USER']['id'] == $user['id']) : ?>
                        <a href="edit_profil.php?id_user=<?php echo $user['id'] ?>">
                            <div class="editprofile">Edit Profile</div>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="bio">
                    <div class="handle">
                        <h3><?php echo $user['username'] ?></h3>
                        <span><?php echo $user['at_user_name'] ?></span>
                    </div>
                    <p><?php echo $user['bio'] ?></p>
                    <span> <i class="fa fa-location-arrow"></i> <?php echo $user['city'] ?> <i class="fa fa-birthday-cake" aria-hidden="true"></i> <?php echo $user['birthdate'] ?></span>
                    <br> <span><i class="fa fa-calendar"></i> <?php echo $user['creation_time'] ?> </span>
                    <div class="follow">
                        <div class="followers">
                            <span onclick="togglePopup1()"><?php echo $follower['count'] ?> Following</span>
                        </div>
                        <div class="following"><span onclick="togglePopup2()"><?php echo $following['count'] ?> Followers</span></div>
                    </div>

                    <div id="popup-overlay1">
                        <div class="popup-content1">
                            <?php foreach ($followingUser as $followings) : ?>
                                <div class="followingPopup">
                                    <img src="<?php echo $path . $followings['profile_picture'] ?>" alt="">
                                    <a style='color:blue' href="user_profil.php?id_user=<?php echo $followings['at_user_name'] ?>"><?php echo $followings['at_user_name'] ?></a>
                                </div>
                            <?php endforeach; ?>
                            <a href="javascript:void(0)" onclick="togglePopup1()" class="popup-exit">Fermer</a>
                        </div>
                    </div>

                    <div id="popup-overlay2">
                        <div class="popup-content2">
                            <?php foreach ($followerUser as $followings) : ?>
                                <div class="followingPopup">
                                    <img src="<?php echo $path . $followings['profile_picture'] ?>" alt="">
                                    <a style='color:blue' href="user_profil.php?id_user=<?php echo $followings['at_user_name'] ?>"><?php echo $followings['at_user_name'] ?></a>
                                </div>
                            <?php endforeach; ?>
                            <a href="javascript:void(0)" onclick="togglePopup2()" class="popup-exit">Fermer</a>
                        </div>
                    </div>

                    <script>
                        function togglePopup1() {
                            let popup = document.querySelector('#popup-overlay1');
                            popup.classList.toggle("open");
                        }

                        function togglePopup2() {
                            let popup = document.querySelector('#popup-overlay2');
                            popup.classList.toggle("open");
                        }
                    </script>

                    <?php if (isset($uFollow['id_user'])) : ?>
                        <?php if ($uFollow['id_user'] != $user['id']) : ?>
                            <a href="../mysql/r_follow.php?id_user=<?php echo $_SESSION['USER']['id'] ?>&id_follow=<?php echo $user['id'] ?>&at_user_name=<?php echo $user['at_user_name'] ?>">+ Unfollow</a>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ($uFollow['id_user'] != $user['id']) : ?>
                            <a href="../mysql/r_follow.php?id_user=<?php echo $_SESSION['USER']['id'] ?>&id_follow=<?php echo $user['id'] ?>&at_user_name=<?php echo $user['at_user_name'] ?>">+ Follow</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="tweets">
                <div class="heading">
                    <a href="../Utilisateur/user_profil.php?id_user=<?php echo $user['at_user_name'] ?>&show=tweet">
                        <p>Tweets/Retweets</p>
                    </a>
                    <a href="../Utilisateur/user_profil.php?id_user=<?php echo $user['at_user_name'] ?>&show=retweetandcomment">
                        <p>Replies</p>
                    </a>

                </div>
            </section>

            <?php
            if ($_GET['show'] == "tweet") {
                include('../Utilisateur/tweet_user.php');
            } else if ($_GET['show'] == "retweetandcomment") {
                include('../Utilisateur/comment_user.php');
            } else {
                include('../Utilisateur/tweet_user.php');
            }

            ?>
        </div>

    </div>


    <!-- <button class="suggestion" onclick="toggleMode()">Dark/Light</button> -->
</div>