<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', 'root', 'GameShift');
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$query = "SELECT * FROM games";
$result = $conn->query($query);
if (!$result) {
    die("Erreur SQL : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="stylesp.css">
</head>
<body>
    <div class="sidebar">
        <h2>Back Office</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">Produits</a></li>
            <li><a href="users.php">Utilisateurs</a></li>
            <li><a href="orders.php">Commandes</a></li>
            <li><a href="reports.php">Rapports</a></li>
            <li><a href="settings.html">Paramètres</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Gestion des Produits</h1>

        <button onclick="window.location.href='add_product.php'" class="add-product-btn">Ajouter un produit</button>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Produit</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Image principale</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Vérification des résultats
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                            <tr>
                                <td>" . htmlspecialchars($row['game_id']) . "</td>
                                <td>" . htmlspecialchars($row['title']) . "</td>
                                <td>" . htmlspecialchars($row['price']) . " €</td>
                                <td>" . htmlspecialchars($row['stock']) . "</td>
                                <td>
                                    <a href='" . htmlspecialchars($row['image_url']) . "' target='_blank'>Voir Image</a>
                                </td>
                                <td>
                                    <a href='edit_product.php?game_id=" . htmlspecialchars($row['game_id']) . "' class='edit-btn'>Modifier</a>
                                    <form method='POST' action='delete_game.php' style='display:inline;'>
                                        <input type='hidden' name='game_id' value='" . htmlspecialchars($row['game_id']) . "'>
                                        <button type='submit' class='delete-btn'>Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='7'>Aucun produit trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
