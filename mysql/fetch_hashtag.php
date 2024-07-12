<?php 

include('mysql.php');

$query = $mysqlClient->prepare("SELECT hashtag FROM hashtag_list");
$query->execute();
$hastags = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($hastags);