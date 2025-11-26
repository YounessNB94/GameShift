<?php
require_once 'utils/bdd/database.php'; 
if (isset($_GET['query'])) {
    $query = htmlspecialchars(trim($_GET['query']));
    try {
        $stmt = $pdo->prepare("
            SELECT game_id, title 
            FROM games 
            WHERE title LIKE :query OR genre LIKE :query OR studio LIKE :query OR platform LIKE :query
            LIMIT 10
        ");
        $stmt->execute(['query' => "%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Erreur lors de la recherche.']);
    }
} else {
    echo json_encode([]); 
}
?>
