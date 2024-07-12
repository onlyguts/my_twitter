<?php
session_start();
if ($_GET['id_user'] == $_SESSION['USER']['id']) {
 
} else {
    $var = $_SESSION['USER']['at_user_name'];
    header('Location: user_profil.php?id_user=' . $var);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/accueil.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../style/profil.css'>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="marging">
        <?php include('../mysql/mysql.php') ?>
        <?php include('../includes/path.php') ?>
        <?php include('../includes/left-sidebar.php') ?>
        <div class="mise-en-page">
            <div class="main-content">
                <div class="container">
                    <div class="form-profil">
                        <form action="../mysql/r_edit_profil.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['USER']['id'] ?>">
                            <label for="username">username :</label>
                            <input type="text" name="username" id="username" value="<?php echo $_SESSION['USER']['username'] ?>">

                            <label for="bio">bio :</label>
                            <input type="text" name="bio" id="bio" value="<?php echo $_SESSION['USER']['bio'] ?>">
                            <label for="city">city :</label>
                            <input type="text" name="city" id="city" value="<?php echo $_SESSION['USER']['city'] ?>">
                            <label for="campus">campus :</label>
                            <input type="text" name="campus" id="campus" value="<?php echo $_SESSION['USER']['campus'] ?>">
                            <input type="hidden" name="action" value="allchange">

                            <input type="submit" value="Modifier le compte">
                        </form>
                        <form action="../mysql/r_edit_profil.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['USER']['id'] ?>">
                            <label for="imageToUpload">pp :</label>
                            <input type="hidden" name="action" value="ppchange">
                            <input type="file" name="imageToUpload" id="imageToUpload">
                            <input type="submit" value="Modifier la pp">
                        </form>
                        <form action="../mysql/r_edit_profil.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['USER']['id'] ?>">
                            <input type="hidden" name="action" value="bannerchange">
                            <label for="imageToUploadBanner">banner :</label>
                            <input type="file" name="imageToUploadBanner" id="imageToUploadBanner">

                            <input type="submit" value="Modifier la bannière">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../includes/right-sidebar.php') ?>
    </div>
</body>

</html>