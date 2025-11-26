<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start(); 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <title>LOG</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>

<header>
    <?php require_once ('composants/nav.php'); ?>
    <?php require_once ('utils/bdd/database.php'); ?>
</header>

<div class="slider">
    <main>
        <br><br><br><br><br><br>

        <h1>Bienvenue sur GameShift</h1>
        <br>
        <p>D&eacutecouvrez les meilleurs jeux vid&eacuteos du moment</p>
        <br><br><br>

        <div class="connecter">
            <?php if (isset($_SESSION['email']) && !empty($_SESSION['email'])): ?>
                <!-- utilisateur  connecté -->
                <a href="jeux.php"><button>Voir les jeux</button></a>
            <?php else: ?>
                <!-- utilisateur pas connecté -->
                <a href="login.php"><button>Se connecter</button></a>
            <?php endif; ?>
        </div>
    </main>
</div>        

<div class="jdls">
    <h1>Les jeux de la semaine</h1>
</div>
<br><br>

<section class="section_produits">
    <div class="produits">
        <?php
        $query = "SELECT * FROM games LIMIT 12";
        $stmt = $pdo->query($query);

        while ($game = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <div class="carte">
                <a href="achat.php?game_id=' . urlencode($game['game_id']) . '">
                    <div class="img"><img src="' . htmlspecialchars($game['image_url']) . '" alt="' . htmlspecialchars($game['title']) . '"></div>
                    <div class="desc">' . htmlspecialchars($game['title']) . ' (' . htmlspecialchars($game['platform']) . ')</div>   
                    <div class="titre">' . htmlspecialchars($game['genre']) . '</div>   
                    <div class="box">
                        <div class="prix">' . number_format($game['price'], 2) . '&euro;</div>
                        <button class="achat">Acheter</button>
                    </div>
                </a>
            </div>';
        }
        ?>
    </div>
    <br><br>
</section>

<br><br><br><br><br><br><br><br>

<?php require_once ('composants/footer.php'); ?>

<script src="logs.js"></script>

</body>
</html>
