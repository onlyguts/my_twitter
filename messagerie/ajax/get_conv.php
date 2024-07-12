<?php

session_start();
include("../../mysql/mysql.php");

$query = $mysqlClient->prepare("SELECT DISTINCT c.id AS id_conv, c.name AS nameConv, c.picture AS imgConv FROM convo c JOIN convo_users cu ON cu.id_convo = c.id WHERE cu.id_user = :id_user");
$query->execute([
    'id_user' => $_SESSION['USER']['id'],
]);
$catchConv = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($catchConv);
