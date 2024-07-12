<?php
include('mysql.php');
session_start();

if ($_GET['id_user'] != $_GET['id_follow']) {
    $sql = $mysqlClient->prepare('SELECT * FROM follow f WHERE f.id_user = :id_user AND f.id_follow = :id_follow');
    $sql->execute([
        "id_user" => $_GET['id_user'],
        "id_follow" => $_GET['id_follow'],
    ]);
    $follow = $sql->fetch(PDO::FETCH_ASSOC);
    if (!isset($follow['id_user'])) {
        $sql = $mysqlClient->prepare('INSERT INTO `follow`(`id_user`, `id_follow`, `time`) VALUES (:id_user,:id_follow,now())');
        $sql->execute([
            "id_user" => $_GET['id_user'],
            "id_follow" => $_GET['id_follow'],
        ]);
    } else {
        $sql = $mysqlClient->prepare('DELETE FROM follow WHERE id_user = :id_user AND id_follow = :id_follow');
        $sql->execute([
            "id_user" => $_GET['id_user'],
            "id_follow" => $_GET['id_follow'],
        ]);
    }
 
} else {
    echo "tu peux pas te follow";
}

header("Location: ../Utilisateur/user_profil.php?id_user=" . $_GET['at_user_name']);