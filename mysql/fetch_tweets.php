<?php
session_start();
include('mysql.php');
include('../includes/path.php');
$sql = $mysqlClient->prepare('SELECT DISTINCT u.id as user_id, t.id as tweet_id, t.content, t.time, u.username, u.at_user_name, u.profile_picture, t.id_quoted_tweet FROM tweet t JOIN user u ON u.id = t.id_user JOIN follow f ON f.id_user = :id WHERE f.id_follow = u.id AND t.id_response IS NULL ORDER BY t.id DESC');
$sql->execute([
    "id" => $_SESSION['USER']['id'],
]);
$tweets = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tweets);
?>