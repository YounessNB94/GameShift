<?php
require_once 'utils/bdd/database.php';


$queryCategories = "SELECT DISTINCT genre FROM games WHERE genre IS NOT NULL ORDER BY genre";
$stmtCategories = $pdo->query($queryCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_GET['genre']) || empty($_GET['genre'])) {
    die('Aucune catégorie sélectionnée.');
}

$genre = htmlspecialchars($_GET['genre']);


$query = "SELECT * FROM games WHERE genre = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$genre]);
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF@-8">
        <title>Jeux - <?= htmlspecialchars($genre); ?></title>
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #121212;
            color: white;
        }

       .sidebar {
    width: 20%;
    background-color: #1e1e1e;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: scroll; 
    scrollbar-width: none; 
    -ms-overflow-style: none; 
}

.sidebar::-webkit-scrollbar {
    display: none; 
}

        .sidebar h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            display: block;
            padding: 10px;
            background-color: #2e2e2e;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #007BFF;
            color: white;
        }

        .main-content {
            margin-left: 20%;
            width: 80%;
            padding: 20px;
        }

        .section_produits {
            padding: 40px 5%; 
        }

        .produits {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 50px;
        }

        .produits .carte a {
            text-decoration: none; 
            color: white; 
            transition: color 0.3s ease; 
        }

        .produits .carte a:hover {
            color: #4897ff;
        }

        .produits .carte {
            width: 220px;
            background: #000000a4;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
        }

        .produits .carte:hover {
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(70, 70, 70, 0.511); 
        }

        .produits .carte img {
            height: 150px;
            width: 100%;
            border-radius: 10px;
        }

        .produits .carte .desc {
            padding: 5px 20px;
            opacity: 0.8;
        }

        .produits .carte .titre {
            font-weight: 900;
            font-size: 15px;
            color: #ffffff;
            padding: 0 20px;
        }

        .produits .carte .box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .produits .carte .prix {
            color: rgb(255, 255, 255);
            font-size: 20px;
            font-weight: bold;
        }

        .produits .carte .achat {
            font-size: 13px;
            font-weight: 500;
            color: rgb(0, 0, 0);
            padding: 10px 10px;
            border-radius: 5px;
        }

        .produits .carte .achat:hover {
            cursor: pointer;
            background: #ffffff;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <header>
            <?php require_once('composants/nav.php'); ?>
        </header>
<br>
<br>
<br>
<br>
<br>

    <div class="sidebar">
<br>
<br>
<br>
<br>
<br>
<br>


        <h2>Cat&eacutegories</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li>
                    <a href="category.php?genre=<?= urlencode($category['genre']); ?>">
                        <?= htmlspecialchars($category['genre']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="main-content">
       
        <section class="section_produits">
<br>
<br>
<br>
<br>
<br>

            <h1 class="produits_texte">Cat&eacutegorie : <?= htmlspecialchars($genre); ?></h1>
            <div class="produits">
                <?php if (!empty($games)): ?>
                    <?php foreach ($games as $game): ?>
                        <div class="carte">
                            <a href="achat.php?game_id=<?= urlencode($game['game_id']); ?>">
                                <div class="img"><img src="<?= htmlspecialchars($game['image_url']); ?>" alt="<?= htmlspecialchars($game['title']); ?>"></div>
                                <div class="desc"><?= htmlspecialchars($game['title']); ?> (<?= htmlspecialchars($game['platform']); ?>)</div>
                                <div class="titre"><?= htmlspecialchars($game['genre']); ?></div>
                                <div class="box">
                                    <div class="prix"><?= number_format($game['price'], 2); ?>&euro;</div>
                                    <button class="achat">
                                        <i class="bi bi-cart-fill"></i> Panier
                                    </button>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun jeu trouv&eacute dans cette cat&eacutegorie.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>
