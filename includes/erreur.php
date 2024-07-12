<?php if (isset($_SESSION['MESSAGE_ERREUR'])) : ?>
    <p> <?php echo $_SESSION['MESSAGE_ERREUR']; unset($_SESSION['MESSAGE_ERREUR']); ?></p>
<?php endif; ?>