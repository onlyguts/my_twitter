<?php 
include('mysql.php');
echo $_POST['id_tweet'] ." user :" . $_POST['id_user'] . $_POST['comment'];

$sql = $mysqlClient->prepare('INSERT INTO `tweet`(`id_user`, `id_response`, `time`, `content`, `id_quoted_tweet`) VALUES (:id, :response, NOW(), :content, :id_quote_tweet)');
$sql->execute([
    "id" => $_POST['id_user'],
    "response" => $_POST['id_tweet'],
    "content" => $_POST['comment'],
    "id_quote_tweet" => NULL,
]);

header('Location: ../tweet/comment.php?id_tweet=' . $_POST['id_tweet']);