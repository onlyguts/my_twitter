<?php if (isset($_SESSION['USER'])) : ?>
    <?php echo "salut " . $_SESSION['USER']['username']; ?>
    <img src="<?php echo $_SESSION['USER']['pp']?>" alt="">
    <a href="./Utilisateur/deconnexion.php">DECO</a>
<?php endif; ?>