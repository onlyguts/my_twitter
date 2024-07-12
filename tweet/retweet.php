<?php 
session_start();
include('../mysql/mysql.php');
include('../includes/path.php');

$sql = $mysqlClient->prepare('SELECT id_user, id_tweet FROM retweet WHERE id_user = :id_user AND id_tweet = :id_tweet');
$sql->execute([
    "id_user" => $_SESSION['USER']['id'],
    "id_tweet" => $_GET['id_tweet']
]);
$UserReTweet = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $mysqlClient->prepare('SELECT rt.id_user, rt.id_tweet, t.id_quoted_tweet FROM retweet rt JOIN tweet t ON t.id = rt.id_tweet WHERE rt.id_tweet = :id_tweet');
$sql->execute([
    "id_tweet" => $UserReTweet['id_tweet']
]);
$UserReTweetRe = $sql->fetch(PDO::FETCH_ASSOC);


if (isset($UserReTweet['id_user']) && isset($UserReTweetRe['id_user'])) {
    echo "trouver";
} else {
    $sql = $mysqlClient->prepare('INSERT INTO `retweet`(`id_user`, `id_tweet`, time) VALUES (:id, :id_tweet, NOW())');
    $sql->execute([
        "id" => $_SESSION['USER']['id'],
        "id_tweet" => $_GET['id_tweet'],
    ]);
    $sql = $mysqlClient->prepare('INSERT INTO `tweet`(`id_user`, `id_response`, `time`, `content`, `id_quoted_tweet`) VALUES (:id, :response, NOW(), :content, :id_quoted_tweet)');
    $sql->execute([
        "id" => $_SESSION['USER']['id'],
        "response" => NULL,
        "content" => "",
        "id_quoted_tweet" => $_GET['id_tweet'],
    ]);
}

header("Location: ../accueil.php");