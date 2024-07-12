<?php session_start();


include('../mysql/mysql.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style/accueil.css">
    <title>Messagerie</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function chargeConv() {
                $.ajax({
                    url: 'ajax/get_conv.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id_user: <?php echo $_SESSION['USER']['id'] ?>,
                    },
                    success: function(reussite, statut) {
                        $('#conv').empty()
                        for (let index = 0; index < reussite.length; index++) {
                            body = " <a href = 'users_messages.php?id=" + reussite[index].id_conv + "'> <div class = 'messages'> " + index + " - " + reussite[index].nameConv + "</div> </a>"
                            $("#conv").append(body);
                        }

                    }
                });
            }
            chargeConv();
            setInterval(chargeConv, 3000);

        });
    </script>
</head>

<body>
    <div class="marging">

        <?php include('../includes/path.php') ?>
        <?php include('../includes/left-sidebar.php') ?>
        <div class="mise-en-page">
            <div>
                <h1>Messages</h1>
                <button onclick="togglePopup()" id="createMessage">Nouveau message</button>

                <?php
                $getData = $_POST;
                if (isset($getData['memberSearch']) && !empty($getData['memberSearch'])) {


                    if (!empty($getData['nameConv']) && $getData['nameConv'] != " ") {
                        $nameConv = $getData['nameConv'];
                    } else {
                        $nameConv = "Conversation de " . $_SESSION['USER']['username'];
                    }

                    if (!empty($getData['imgConv'])) {
                        $imgConv = $getData['imgConv'];
                    } else {
                        $imgConv = "assets/img/user.png";
                    }

                    $query = $mysqlClient->prepare("INSERT INTO convo (name, picture) VALUES (:name, :img)");
                    $query->execute([
                        "name" => $nameConv,
                        "img" => $imgConv,
                    ]);

                    $query = $mysqlClient->prepare("SELECT id FROM convo ORDER BY id DESC LIMIT 1");
                    $query->execute([]);
                    $Conv = $query->fetch(PDO::FETCH_ASSOC);

                    array_push($getData['memberSearch'], $_SESSION['USER']['id']);
                    foreach ($getData['memberSearch'] as $getMember) {
                        $query = $mysqlClient->prepare("INSERT INTO convo_users (id_convo, id_user, time) VALUES (:id_convo, :id_user, now())");
                        $query->execute([
                            "id_convo" => $Conv['id'],
                            "id_user" => $getMember,
                        ]);
                    }
                }

                ?>

                <div id="popup-overlay">
                    <div class="popup-content">
                        <form action="" method="post">
                            <h2>Nouveau message</h2>

                            <input type="search" name="searchUser" id="searchUser" placeholder="Cherche un membre" onkeyup="search_user()">


                            <?php
                            $query = $mysqlClient->prepare("SELECT DISTINCT username, at_user_name, profile_picture, id FROM user 
                                                WHERE id != :id_user");
                            $query->execute([
                                'id_user' => $_SESSION['USER']['id'],
                            ]);
                            $catchUser = $query->fetchAll(PDO::FETCH_ASSOC);

                            if ($catchUser) :
                                foreach ($catchUser as $Users) : ?>
                                    <div class="membres">
                                        <input type="checkbox" name="memberSearch[]" id="memberSearch" value="<?php echo $Users['id'] ?>">
                                        <label for="memberSearch"><?php echo $Users['username'] ?></label>
                                    </div>
                                <?php endforeach ?>
                            <?php else :
                                echo "pas d'utilisateur.";
                            endif;
                            ?>

                            <a href="javascript:void(0)" onclick="togglePopup()" class="popup-exit">Fermer</a>
                            <label for="nameConv">Nom du groupe :</label>
                            <input type="text" name="nameConv" id="nameConv"><br>
                          
                            <input type="submit" value="Créer un groupe">
                        </form>
                    </div>
                </div>

                <input type="search" name="searchUserConv" id="searchUserConv" placeholder="Chercher des conversations" onkeyup="search_conv()">

                <div id="conv"></div>



                <script src="script.js"></script>
            </div>
        </div>
        <?php include('../includes/right-sidebar.php') ?>
    </div>

</body>

</html>