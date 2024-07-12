<?php
class functions
{
    // Function qui ce lance quand on créer un compte
    public function creation_compte()
    {
        // Genere le captcha 
        if (!isset($_POST['verif_bot'])) {
            $bytes = random_bytes(2);
            $VerifBasique = bin2hex($bytes);
        }
        // Verifie si le code captcha est  bon 
        if ($_POST['verif_bot'] === $_POST['hidden_verif']) {
            if (isset($_POST['verif_bot'])) {
                $verif = new functions;
                $verif->creation_compte_sql(); // renvoye vers la partie SQL de la creation du compte
            }
        } else {
            $_SESSION['MESSAGE_ERREUR'] = "code bot pas bon";
        }
        return $VerifBasique;
    }

    // Renvoie ici
    public function creation_compte_sql()
    {
        include('mysql.php');
        if ($_POST['password'] === $_POST['passwordcheck']) { // On verifie si le password et le 2eme
            if (strlen($_POST['password']) >= 6) { // si le mdp contient 6 character 
                $sql = $mysqlClient->prepare('SELECT * FROM user WHERE mail = :email');
                $sql->execute([
                    "email" => $_POST['email'],
                ]);
                $email_verif = $sql->fetch(PDO::FETCH_ASSOC);
                if (!isset($email_verif['id'])) {  // requete pour voir si l'email et déjà existante
                    $sql = $mysqlClient->prepare('SELECT * FROM user WHERE at_user_name = :at_user_name');
                    $sql->execute([
                        "at_user_name" => "@" . $_POST['username'],
                    ]);
                    $at_user_name_verif = $sql->fetch(PDO::FETCH_ASSOC);
                    if (!isset($at_user_name_verif['id'])) {  // requete pour voir si l'@ et déjà existant
                        include('includes/define.php');
                      
                        if ($_FILES["imageToUpload"]['name'] != "") {
                            if ($_FILES['imageToUpload']['size'] < 5 * MB) {  // si le photo de profil fait - 5MB
                                if ($_FILES["imageToUpload"]["type"] == "image/jpeg" || $_FILES["imageToUpload"]["type"] == "image/png" || $_FILES["imageToUpload"]["type"] == "image/jpg") {  // si la photo de profil et en JPEG ou PNG
                                  
                                    $directory = "assets/save_image_user/";
                                    $filecount = count(glob($directory . "*"));
                                    move_uploaded_file($_FILES['imageToUpload']['tmp_name'], "assets/save_image_user/" . $filecount . $_FILES['imageToUpload']['name']);  // ajoute la photo de profil dans un dossier

                                    $sql = $mysqlClient->prepare('INSERT INTO `user`(`username`, `at_user_name`, `profile_picture`, `bio`, `banner`, `mail`, `password`, `birthdate`, `private`, `creation_time`, `city`, `campus`) VALUES (:username, :at_username, :pp, null, "assets/img/banner.png", :mail, :password, :date, 0,NOW(),null,null);');
                                    $sql->execute([
                                        "username" => $_POST['username'],
                                        "at_username" => "@" . $_POST['username'],
                                        "mail" => $_POST['email'],
                                        "pp" => "assets/save_image_user/" . $filecount . $_FILES['imageToUpload']['name'],
                                        "date" => $_POST['date'],
                                        "password" => hash("ripemd160", $_POST['password'], FALSE),
                                    ]);
                                    $_SESSION['MESSAGE_ERREUR'] = "good";
                                } else {
                                    $_SESSION['MESSAGE_ERREUR'] = "pas le bon type de fichier uniquement (png/jpeg)";
                                }
                            } else {
                                $_SESSION['MESSAGE_ERREUR'] = "image +5mb";
                            }
                        } else {
                            $sql = $mysqlClient->prepare('INSERT INTO `user`(`username`, `at_user_name`, `profile_picture`, `bio`, `banner`, `mail`, `password`, `birthdate`, `private`, `creation_time`, `city`, `campus`) VALUES (:username, :at_username, "assets/img/user.png", null, "assets/img/banner.png", :mail, :password, :date, 0,NOW(),null,null);');
                            $sql->execute([
                                "username" => $_POST['username'],
                                "at_username" => "@" . $_POST['username'],
                                "mail" => $_POST['email'],
                               
                                "date" => $_POST['date'],
                                "password" => hash("ripemd160", $_POST['password'], FALSE),
                            ]);
                            $_SESSION['MESSAGE_ERREUR'] = "good";
                        }

                          
                    } else {
                        $_SESSION['MESSAGE_ERREUR'] = "deja le @";
                    }
                } else {
                    $_SESSION['MESSAGE_ERREUR'] = "déjà la email";
                }
            } else {
                $_SESSION['MESSAGE_ERREUR'] = "mdp trop petit";
            }
        } else {
            $_SESSION['MESSAGE_ERREUR'] = "mdp check pas bon";
        }
    }
    public function login()
    {
        include('mysql.php');
        include('../includes/path.php');
        if (isset($_POST['login'])) {
            $sql = $mysqlClient->prepare('SELECT * FROM user WHERE mail = :email OR at_user_name = :username'); // connexion avec login ou email
            $sql->execute([
                "username" => "@" . $_POST['username'],
                "email" => $_POST['username'],
            ]);
            $user = $sql->fetch(PDO::FETCH_ASSOC);

            if (isset($user['id'])) {
                // on verifie si le password et le même 
                if ($user['password'] == hash("ripemd160", $_POST['password'], FALSE)) {
                    $filename = $user['profile_picture'];
                    $pp = '';
                    if (file_exists($filename)) {
                        $pp = $user['profile_picture'];
                    } else {
                        $pp = "http://localhost/ATweet/assets/img/user.png";
                        $sql = $mysqlClient->prepare("UPDATE `user` SET `profile_picture`='assets/img/user.png' WHERE id = :id"); // connexion avec login ou email
                        $sql->execute([
                            "id" => $user['id'],
                        ]);
                    }
                    // ON CREER LA SESSION DE LUSER QUAND IL CE CONNECTE TRES IMPORTANT !
                    $_SESSION['USER'] = [
                        "id" => $user['id'],
                        "username" => $user['username'],
                        "at_user_name" => $user['at_user_name'],
                        "pp" => $pp,
                        "banner" => $user['banner'],
                        "bio" => $user['bio'],
                        "city" => $user['city'],
                        "campus" => $user['campus'],
                    ];
                    header("Location: accueil.php");
                } else {
                    $_SESSION['MESSAGE_ERREUR'] = "mdp pas bon";
                }
            } else {
                $_SESSION['MESSAGE_ERREUR'] = " email/username pas trouver";
            }
        }
    }
}
