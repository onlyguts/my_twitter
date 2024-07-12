<?php
include('mysql.php');
include('../includes/path.php');

$sql = $mysqlClient->prepare('SELECT u.username, u.at_user_name, u.profile_picture, t.id as tweet_id, t.content as rt_content, t.time FROM user u JOIN tweet t ON t.id_user = u.id WHERE t.id = :id ORDER BY t.id DESC');
$sql->execute([
    "id" => $_GET['id_quoted_tweet'],
]);
$tweets = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tweets);
