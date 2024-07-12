<?php


$sql = $mysqlClient->prepare('SELECT * FROM user ORDER BY RAND() LIMIT 5');
$sql->execute([
]);

$usersugg = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $mysqlClient->prepare("SELECT t.content  FROM tweet t JOIN hashtag_list hl WHERE t.content LIKE CONCAT('%', '#', hl.hashtag, '%')");
$sql->execute([]);
$hashtag = $sql->fetchAll(PDO::FETCH_ASSOC);


$sql = $mysqlClient->prepare("SELECT hl.hashtag, COUNT(*) as count FROM tweet t  JOIN hashtag_list hl ON t.content LIKE CONCAT('%', '#', hl.hashtag, '%') GROUP BY hl.hashtag ORDER BY count DESC LIMIT 10");
$sql->execute([]);
$hashtag2 = $sql->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="right-sidebar">
      <input type="text" class="search-bar" id="SearchHashtag" placeholder="Recherche #">
      <div class="box-result"></div>
      <input type="text" class="search-bar" id="SearchUser" placeholder="Recherche @">
      <div class="boxResult"></div>
   
      <div class="suggestion tendance">
        <?php foreach ($hashtag2 as $hashtag) : ?>
        <div class="tendance-list">
          <a href="<?php echo $path ?>tweet/hashtag.php?hashtag=<?php echo $hashtag['hashtag'] ?>"><?php echo "#" . $hashtag['hashtag'] ?></a>
          <p>Tweet(s) : <?php echo $hashtag['count'] ?></p>
        </div>
        <?php endforeach; ?>
      </div>
      
      <div class="sugguser">
        <h1>Suggestion User</h1>
        <?php foreach ($usersugg as $users) : ?>
        <div class="profilpost background marging">
          <div class="photodeprofil">
            <img href="#" src="<?php echo $path ?><?php echo $users['profile_picture'] ?>" alt="photodeprofil">
          </div>
          <div class="infoprofilontwit">
            <div class="nomutilisateur">
              <a href="#"><?php echo $users['username'] ?></a>
            </div>
            <div class="pseudo">
              <a style="color:blue" href="<?php echo $path ?>Utilisateur/user_profil.php?id_user=<?php echo $users['at_user_name'] ?>"><?php echo $users['at_user_name'] ?></a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
       
      </div>
      <div>

      <script src="searchHashtag.js"></script>
      <script src="searchUsers.js"></script>
    