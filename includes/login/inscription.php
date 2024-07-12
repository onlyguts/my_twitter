<div id="popup-overlay1">
    <div class="popup-content1">
        <form action="" method="post" enctype="multipart/form-data">
            <h2>Créez votre compte</h2>
            <label for="username">Nom Utilisateur :</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
            <label for="date">Date anniv</label>
            <input type="date" name="date" id="date" required>
            <label for="imageToUpload">Photo de profil ( pas obligatoire )</label>
            <input type="file" name="imageToUpload">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            <label for="passwordcheck">Retapez votre mot de passe :</label>
            <input type="password" name="passwordcheck" id="passwordcheck" required>
            <input type="hidden" name="register" id="register">
            <div class="bot">
                <label class="verif" for="verif_bot">
                    <p><?php echo $VerifBasique ?></p>
                </label>
            </div>
            <input type="text" name="verif_bot" id="verif_bot">
            <input type="hidden" name="hidden_verif" value="<?php echo $VerifBasique ?>">
            <input type="submit" value="Crée le compte">
            <a href="javascript:void(0)" onclick="togglePopup1()" class="popup-exit">Fermer</a>
        </form>
    </div>
</div>