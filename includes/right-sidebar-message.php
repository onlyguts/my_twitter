<div class="right-sidebar">
    <input type="search" class="search-bar" placeholder="Search barre">
    <div class="suggestion tendance">

        <div class="conversation">
            <a href="#">
            
                <?php echo $convInfo['name'] ?>
            </a> <!-- nom de la convo qui amene sur la convo limite 10 dans la db  -->

        </div>
        <div>
        <a href="users_convo.php">Retour</a>
        <button onclick="togglePopup()" id="editGroup">Editer le groupe</button>
        </div>
       

    </div>
    <div class="sugguser">
        <!-- les folower du profil connecté limite de 5 sur la requette mysql pour pas casser l'affichage-->
        <div class=" marging profilpost background">
            <div>
                <?php foreach ($convUser as $convUsers): ?>

                    <div class="infoprofilontwit">

                        <div class="nomutilisateur">
                            <div class="photodeprofil">
                                <img href="#" src="<?php echo $path . $convUsers['profile_picture'] ?>" alt="photodeprofil">

                                <a href="#">
                                    <?php echo $convUsers['username'] ?>
                                </a>

                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>