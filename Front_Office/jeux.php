<?php
session_start(); // Toujours au début de votre fichier
// Votre code ici
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF@-8">
    <title>Jeux</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>
<header>
<?php require_once ('composants/nav.php') ?>
<?php require_once ('utils/bdd/database.php'); ?>

</header>
    <main>
     
 
  <br>
  <?php
// Récupérer un jeu aléatoire depuis la base de données
$query_random = "SELECT * FROM games ORDER BY RAND() LIMIT 1";
$stmt_random = $pdo->query($query_random);
$random_game = $stmt_random->fetch(PDO::FETCH_ASSOC);
?>
<div class="slider_hero">
    <?php if ($random_game): ?>
        <!-- Image de fond floutée -->
        <img src="<?= htmlspecialchars($random_game['image_url']); ?>" alt="<?= htmlspecialchars($random_game['title']); ?>" class="slider-hero-image">

        <!-- Contenu du slider -->
         <br>
        <div class="slider-hero-content">
             <img src="<?= htmlspecialchars($random_game['image_url']); ?>" alt="<?= htmlspecialchars($random_game['title']); ?>" class="center-game-image">
            <!-- Texte superposé -->
            <div class="slider-hero-text">
                <h1><?= htmlspecialchars($random_game['title']); ?></h1>
                <p><?= htmlspecialchars($random_game['description']); ?></p> 
                
                <p class="slider-hero-price"><?= number_format($random_game['price'], 2); ?>€</p>
                <a href="achat.php?game_id=<?= urlencode($random_game['game_id']); ?>" class="btn-buy">Acheter</a>
            </div>
            <br>

            <!-- Image principale au centre -->
          
        </div>
    <?php else: ?>
        <p>Aucun jeu disponible pour le moment.</p>
    <?php endif; ?>
</div>


 <h1>Jeux PC</h1>   
        <section class="section_produits">
            <div class="produits">
                <?php
               
                $query = "SELECT * FROM games LIMIT 100";
                $stmt = $pdo->query($query);

                // Boucle pour afficher chaque jeu dans une carte
                while ($game = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="carte">
                        <a href="achat.php?game_id=' . urlencode($game['game_id']) . '">
                            <div class="img"><img src="' . htmlspecialchars($game['image_url']) . '" alt="' . htmlspecialchars($game['title']) . '" width="150" height="200"></div>
                            <div class="desc">' . htmlspecialchars($game['title']) . ' (' . htmlspecialchars($game['platform']) . ')</div>   
                            <div class="titre">' . htmlspecialchars($game['genre']) . '</div>   
                            <div class="box">
                                <div class="prix">' . number_format($game['price'], 2) . '€</div>
                                <button class="achat">
    <i class="bi bi-cart-fill"></i> Panier
</button>
                            </div>
                        </a>
                    </div>';
                }
                ?>
            </div>
            <br><br>
            <button id="voirPlusButton">Voir plus</button>
        </section>
    </main>

    <?php require_once ('composants/footer.php'); ?>
















</body>
</html>
