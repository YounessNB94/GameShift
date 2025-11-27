<?php 
session_start();
require_once 'utils/bdd/database.php';

if (!isset($_GET['game_id']) || $_GET['game_id'] === '') {
    echo "ERREUR : Aucun jeu sélectionné.";
    exit;
}

$game_id = $_GET['game_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM games WHERE game_id = ?");
    $stmt->execute([$game_id]);
    
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$game) {
        echo "Jeu non trouvé.";
        exit;
    }

} catch(PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($game['title']); ?> | Vente de Jeux Vidéo</title>
  

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .banner {
            position: relative;
            height: 550px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #222;
        }

        .banner-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(10px);
            opacity: 0.6;
        }

        .small-game-image {
            position: relative;
            z-index: 1;
            width: 700px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        .banner-text {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
        }

        .banner-text h1 {
            font-size: 2.5em;
            margin: 0;
        }

        .banner-text p {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .details-section {
            display:flex;
            flex-direction: column;
            
            max-width: 100%;
            
            margin top:0px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color:white;
            background-color: #000000d8;
        }

        .details-section h2 {
            font-size: 2em;
            margin-bottom: 10px;
            display:flex;
            justify-content:center;
        }

        .details-section p {
            font-size: 1.1em;
            line-height: 1.6;
        }

        .btn-buy {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-buy:hover {
            background-color: #0056b3;
        }

        #main-media {
            max-width: 100%;
            margin: 20px auto;
            text-align: center;
        }

        #main-image, #main-video {
            max-width: 20%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .thumbnails {
    display: flex;
    justify-content: center;
    gap: 10px; 
}

.thumbnail {
    width: 150px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s, opacity 0.2s;
}

.thumbnail:hover {
    transform: scale(1.1);
    opacity: 0.8;
}

       
        .thumbnail[alt="Vidéo"] {
            background-color: #000;
            color: #fff;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .game-details {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-top: 20px;
}
.media {
    flex: 1;
    display: flex;
    flex-direction: column; 
    align-items: center;
    gap: 15px; 
}

.description {
    flex: 1;
    max-width: 400px; 
}


#main-media {
    width: 100%; 
    text-align: center;
}

        footer {
    color: white; 
    background-color: #000; 
    padding: 20px; 
    text-align: center;
}

    </style>
</head>
<body>
<header>
<?php require_once ('composants/nav.php') ?>


</header>
    <div class="banner">
        <img src="<?php echo htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" class="banner-image">
        <div class="banner-text">
            <h1><?php echo htmlspecialchars($game['title']); ?></h1>
            <p><?php echo htmlspecialchars($game['description']); ?></p>
        </div>
        <img src="<?php echo htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" class="small-game-image">
    </div>

    <div class="details-section">
    <h2><?php echo htmlspecialchars($game['title']); ?></h2>
    <div class="game-details">
        <div class="media">
            <div id="main-media">
                <?php if (!empty($game['video'])): ?>
                    <video controls id="main-video">
                        <source src="<?php echo htmlspecialchars($game['video']); ?>" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                <?php else: ?>
                    <img src="<?php echo htmlspecialchars($game['image_1']); ?>" id="main-image" alt="Image principale de <?php echo htmlspecialchars($game['title']); ?>">
                <?php endif; ?>
            </div>
            <div class="thumbnails">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if (!empty($game["image_$i"])): ?>
                        <img src="<?php echo htmlspecialchars($game["image_$i"]); ?>" alt="Image <?php echo $i; ?>" class="thumbnail" onclick="changeMedia('<?php echo htmlspecialchars($game["image_$i"]); ?>', 'image')">
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if (!empty($game['video'])): ?>
                    <img src="https://www.shutterstock.com/shutterstock/videos/1102576935/thumb/2.jpg?ip=x480" alt="Vidéo" class="thumbnail" onclick="changeMedia('<?php echo htmlspecialchars($game['video']); ?>', 'video')">
                <?php endif; ?>
            </div>
        </div>

        <div class="description">
            <p><strong>Plateforme:</strong> <?php echo htmlspecialchars($game['platform']); ?></p>
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($game['genre']); ?></p>
            <p><strong>Classification PEGI:</strong> <?php echo htmlspecialchars($game['pegi_rating']); ?></p>
            <p><strong>Studio:</strong> <?php echo htmlspecialchars($game['studio']); ?></p>
            <p><strong>Date de sortie:</strong> <?php echo date('d/m/Y', strtotime($game['release_date'])); ?></p>
            <p><?php echo htmlspecialchars($game['description']); ?></p>
            <h3>Prix: <?php echo number_format($game['price'], 2); ?> €</h3>
            <p>Stock disponible: <?php echo $game['stock']; ?></p>
            <p>Note moyenne: <?php echo number_format($game['rating'], 1); ?>/5</p>

            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
                <button type="submit" class="btn-buy">Ajouter au panier</button>
            </form>
        </div>
    </div>
</div>
    <script>
        function changeMedia(source, type) {
            const mainMediaContainer = document.getElementById('main-media');
            mainMediaContainer.innerHTML = ''; //efface le contenu actu

            if (type === 'image') {
                const newImage = document.createElement('img');
                newImage.id = 'main-image';
                newImage.src = source;
                newImage.style.maxWidth = '100%';
                newImage.style.borderRadius = '10px';
                newImage.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.2)';
                mainMediaContainer.appendChild(newImage);
            } else if (type === 'video') {
                const newVideo = document.createElement('video');
                newVideo.id = 'main-video';
                newVideo.src = source;
                newVideo.controls = true;
                newVideo.style.maxWidth = '100%';
                newVideo.style.borderRadius = '10px';
                newVideo.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.2)';
                mainMediaContainer.appendChild(newVideo);
            }
        }

        function toggleFullscreen() {
            const mediaContainer = document.getElementById('main-media');
            if (mediaContainer.requestFullscreen) {
                mediaContainer.requestFullscreen();
            } else if (mediaContainer.webkitRequestFullscreen) { /* Safari */
                mediaContainer.webkitRequestFullscreen();
            } else if (mediaContainer.msRequestFullscreen) { /* IE11 */
                mediaContainer.msRequestFullscreen();
            }
        }
    </script>

    
<footer>

<h1>Inscription à la Newsletter</h1>


<h3>Restez Connecté avec GameShift !</h3>
<br>
<p>Inscrivez-vous à notre newsletter pour recevoir les dernières actualités, <br>des offres exclusives, et des informations sur les nouveaux jeux.<br> Soyez le premier à connaître nos promotions et à découvrir les tendances du moment !<br>

Entrez votre email ci-dessous et rejoignez notre communauté de passionnés de jeux vidéo !

</p>
<br>
<br>

<form action="inscription.php" method="POST">
        <label for="email">Entrez votre email :</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">S'inscrire</button>

</footer>

</body>
</html>
