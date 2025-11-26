<?php
require_once 'utils/bdd/database.php';

$query = isset($_GET['query']) ? htmlspecialchars(trim($_GET['query'])) : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <style>
        .carte.hidden {
            display: none;
        }

        #voirPlusButton {
            display: flex;
            margin: 0 auto;
            font-size: 14px;
            padding: 8px 12px;
            margin-top: 20px;
            cursor: pointer;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #voirPlusButton:hover {
            background-color: #0056b3;
        }

        .produits_texte {
            text-align: center;
            display: flex;
            justify-content: center;
            font-size: 30px;
            font-weight: 300;
            margin-top: 30px;
            margin-left: 80px;
            color: #ffffff;
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
            background-color: white;
        }

        .produits .carte .box .achat:hover {
            cursor: pointer;
            background: #ffffff;
            color: #ffffff;
        }
    </style>
</head>
<body>
<header>
<?php require_once ('composants/nav.php') ?>
</header>
    <main>
<br>
<br>
<br>
<br>
<br>
<br>
      
        <section class="section_produits">
            <div class="produits">
                <?php
                if (!empty($query)) {
                    $stmt = $pdo->prepare("
                        SELECT * 
                        FROM games 
                        WHERE title LIKE :query 
                        OR genre LIKE :query 
                        OR platform LIKE :query 
                        OR studio LIKE :query
                        LIMIT 100
                    ");
                    $stmt->execute(['query' => "%$query%"]);
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($results) > 0) {
                        foreach ($results as $game) {
                            echo '
                            <div class="carte">
                                <a href="achat.php?game_id=' . urlencode($game['game_id']) . '">
                                    <div class="img">
                                        <img src="' . htmlspecialchars($game['image_url']) . '" alt="' . htmlspecialchars($game['title']) . '">
                                    </div>
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
                    } else {
                        echo '<p class="produits_texte">Aucun jeu trouvé correspondant à votre recherche.</p>';
                    }
                } else {
                    echo '<p class="produits_texte">Veuillez saisir un terme de recherche.</p>';
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>
