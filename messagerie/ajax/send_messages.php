<?php
session_start();
include("../../mysql/mysql.php");

$query = $mysqlClient->prepare("INSERT INTO messages(id_convo, id_user, content, time) VALUES (:id_convo, :id_user, :content, now())");
$query->execute([
    'id_convo' => $_POST['id'],
    'id_user' => $_SESSION['USER']['id'],
    'content' => $_POST['message'],
]);

?>

