<?php

class profil {
    public function getUser($getIdUser) {
        include('mysql.php');
            $sql = $mysqlClient->prepare('SELECT `id`, `username`, `at_user_name`, `profile_picture`, `bio`, `banner`, `mail`, `password`, `birthdate`, `private`, DATE_FORMAT(creation_time, "%d/%m/%Y") as creation_time, `city`, `campus` FROM user WHERE at_user_name = :id'); // connexion avec login ou email
            $sql->execute([
                "id" => $getIdUser,
            ]);
            $user = $sql->fetch(PDO::FETCH_ASSOC);
            return $user;
    }
}