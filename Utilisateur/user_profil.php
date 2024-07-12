<?php
session_start();

$user_profil = $_GET['id_user'];
$user_logged = $_SESSION['USER']['id'];



include('../mysql/r_profil.php');
include('../includes/path.php');
$verif = new profil;
$user = $verif->getUser($user_profil);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/accueil.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../style/profil.css'>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="marging">
    <?php include('../mysql/mysql.php') ?>
    <?php include('../includes/path.php') ?>
        <?php include('../includes/left-sidebar.php') ?>
        <?php include('../includes/profil.php') ?>
        <?php include('../includes/right-sidebar.php') ?>
    </div>
</body>

</html>