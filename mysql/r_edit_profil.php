<?php
session_start();
include('mysql.php');
include('../includes/path.php');

//  if ($_FILES['imageToUpload']['size'] < 5 * MB) {  // si le photo de profil fait - 5MB

$directory = "../assets/save_image_user/";
$filecount = count(glob($directory . "*"));

if ($_POST['action'] == "allchange") {
    $sql = $mysqlClient->prepare('UPDATE `user` SET username = :username, bio = :bio, private = :private, city = :city, campus = :campus WHERE id = :id'); // connexion avec login ou email
    $sql->execute([
        "id" => $_POST['id'],
        "username" => $_POST['username'],
        "bio" => $_POST['bio'],   
        "private" => 0,
        "city" => $_POST['city'],
        "campus" => $_POST['campus'],
    ]);
}
if ($_POST['action'] == "bannerchange") {
    include('../includes/define.php');
    if ($_FILES['imageToUploadBanner']['size'] < 5 * MB) {  // si le photo de profil fait - 5MB
        if ($_FILES["imageToUploadBanner"]["type"] == "image/jpeg" || $_FILES["imageToUploadBanner"]["type"] == "image/png" || $_FILES["imageToUploadBanner"]["type"] == "image/jpg") {  // si la photo de profil et en JPEG ou PNG

            if (isset($_FILES['imageToUploadBanner'])) {
                unlink("../" . $_SESSION['USER']['banner']);
                move_uploaded_file($_FILES['imageToUploadBanner']['tmp_name'], "../assets/save_image_user/" . $filecount . $_FILES['imageToUploadBanner']['name']);  // ajoute la photo de profil dans un dossier
            }

            $sql = $mysqlClient->prepare('UPDATE `user` SET banner = :banner WHERE id = :id'); // connexion avec login ou email
            $sql->execute([
                "id" => $_POST['id'],
                "banner" => "assets/save_image_user/" . $filecount . $_FILES['imageToUploadBanner']['name'],
            ]);
        } else {
            echo "pas le bon type de fichier uniquement (png/jpeg)";
        }
    } else {
        $_SESSION['MESSAGE_ERREUR'] = "image +5mb";
    }
}

if ($_POST['action'] == "ppchange") {
    include('../includes/define.php');
    if ($_FILES['imageToUpload']['size'] < 5 * MB) {  // si le photo de profil fait - 5MB
        if ($_FILES["imageToUpload"]["type"] == "image/jpeg" || $_FILES["imageToUpload"]["type"] == "image/png" || $_FILES["imageToUpload"]["type"] == "image/jpg") {  // si la photo de profil et en JPEG ou PNG

            if (isset($_FILES['imageToUpload'])) {
                unlink("../" . $_SESSION['USER']['pp']);
                move_uploaded_file($_FILES['imageToUpload']['tmp_name'], "../assets/save_image_user/" . $filecount . $_FILES['imageToUpload']['name']);  // ajoute la photo de profil dans un dossier
            }
            $sql = $mysqlClient->prepare('UPDATE `user` SET profile_picture = :imageToUpload WHERE id = :id'); // connexion avec login ou email
            $sql->execute([
                "id" => $_POST['id'],
                "imageToUpload" => "assets/save_image_user/" . $filecount . $_FILES['imageToUpload']['name'],
            ]);
        } else {
            echo "pas le bon type de fichier uniquement (png/jpeg)";
        }
    } else {
        $_SESSION['MESSAGE_ERREUR'] = "image +5mb";
    }

  
}
header('Location: ../Utilisateur/edit_profil.php?id_user=' . $_SESSION['USER']['id']);