<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Autocomplete - Default functionality</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <?php

    include('mysql/mysql.php');
    $sql = $mysqlClient->prepare('SELECT hashtag FROM hashtag_list');
    $sql->execute([
    ]);
    $hashtag_list = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($hashtag_list as $hashtag_lists) {
        $var = str_replace('"', ' ', $hashtag_lists['hashtag']);
        $usernames[] = "#" .$var;
    
    }
    ?>
    <script>
        $(function() {
            var availableTags = <?= json_encode($usernames); ?>

            $("#tags").autocomplete({
                source: availableTags
            });
        });
    </script>
</head>

<body>

    <div class="ui-widget">
        <label for="tags">Tags: </label>
        <input id="tags">
    </div>


</body>

</html>