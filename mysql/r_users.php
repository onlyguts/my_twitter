<?php 

include('mysql.php');

$query = $mysqlClient->prepare("SELECT at_user_name FROM user");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);