<?php
session_start();

if (isset($_SESSION['USER'])) {
    header('Location: accueil.php');
}
include('mysql/r_login.php');
$verif = new functions;
$VerifBasique = $verif->creation_compte();
$verif->login();
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tweet Academie</title>
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/fix.css">
</head>

<body>

    <div class="conteneur">
        <div class="colonne1">
        <img src="<?php echo $path ?>assets/Logo2.png" alt="">
        </div>
        <div class="colonne2">
            <button onclick="togglePopup1()" id="create">Créez votre compte</button>
            <button onclick="togglePopup2()" id="connect">Se connecter</button>
            <?php include('./includes/erreur.php') ?>
        </div>

    </div>
    <?php include('includes/login/inscription.php'); ?>
    <?php include('includes/login/connexion.php'); ?>
    <script src="script.js"></script>
</body>

</html>