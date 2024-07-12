<?php 

include('../../mysql/mysql.php');

$query = $mysqlClient->prepare("SELECT messages.*, user.username, user.profile_picture as pp, user.id as user_id FROM messages JOIN user ON user.id = messages.id_user WHERE id_convo = :id");
$query->execute([
    'id' => $_GET['id'],
]);
$getConv = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($getConv);
?>