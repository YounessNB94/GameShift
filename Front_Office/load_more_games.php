<?php
require_once ('utils/bdd/database.php');

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = 15; 

$query = "SELECT * FROM games LIMIT $offset, $limit";
$stmt = $pdo->query($query);

$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($games as $game) {
    echo '
    <div class="carte">
        <a href="achat.php?game_id=' . urlencode($game['game_id']) . '">
            <div class="img"><img src="' . htmlspecialchars($game['image_url']) . '" alt="' . htmlspecialchars($game['title']) . '" width="150" height="200"></div>
            <div class="desc">' . htmlspecialchars($game['title']) . ' (' . htmlspecialchars($game['platform']) . ')</div>   
            <div class="titre">' . htmlspecialchars($game['genre']) . '</div>   
            <div class="box">
                <div class="prix">' . number_format($game['price'], 2) . '$</div>
                <button class="achat">Acheter</button>
            </div>
        </a>
    </div>';
}
?>