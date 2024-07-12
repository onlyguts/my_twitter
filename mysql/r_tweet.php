<?php
session_start();
include('mysql.php');

$cl = strlen($_POST['txtTweet']);

$ma_varaible_string = $_POST['txtTweet'];
$trouver = '#';
$position = strrchr($ma_varaible_string, $trouver);
$resultat = explode(' ',  substr($position, 1));

echo $cl;
if ($cl <= 140) {
    if ($cl > 0) {
        if ($resultat[0] != '') {
            $sql = $mysqlClient->prepare('SELECT * FROM hashtag_list WHERE hashtag = :hashtag');
            $sql->execute([
                "hashtag" => $resultat[0],
            ]);
            $hashtag = $sql->fetch(PDO::FETCH_ASSOC);
            if (!isset($hashtag['id'])) {
                $sql = $mysqlClient->prepare('INSERT INTO hashtag_list (hashtag) VALUES (:hashtag)');
                $sql->execute([
                    "hashtag" => $resultat[0],
                ]);
            }
        }
        
        $sql = $mysqlClient->prepare('INSERT INTO `tweet`(`id_user`, `id_response`, `time`, `content`, `id_quoted_tweet`) VALUES (:id, :response, NOW(), :content, :id_quote_tweet)');
        $sql->execute([
            "id" => $_POST['id_user'],
            "response" => NULL,
            "content" => $_POST['txtTweet'],
            "id_quote_tweet" => NULL,
        ]);
    }
}

header("Location: ../accueil.php");
