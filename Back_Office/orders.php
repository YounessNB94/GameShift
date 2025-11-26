<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $conn = new mysqli('localhost', 'root', 'root', 'GameShift');
    $conn = new mysqli('localhost', 'root', '', 'GameShift');

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$query = "
    SELECT 
        orders.order_id, 
        users.username, 
        orders.order_date, 
        orders.total_amount, 
        orders.user_id
    FROM orders
    JOIN users ON orders.user_id = users.user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes - Gestion</title>
    <link rel="stylesheet" href="styleso.css">
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
        <h1>Gestion des Commandes</h1>
        <table>
            <thead>
                <tr>
                    <th>ID de Commande</th>
                    <th>Utilisateur</th>
                    <th>Date de Commande</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                            <tr>
                                <td>{$row['order_id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['order_date']}</td>
                                <td>{$row['total_price']} €</td>
                                <td>
                                    <a href='game.php?game_id={$row['game_id']}' class='view-btn'>Voir</a>
                                    <form method='POST' action='delete_order.php' style='display:inline;'>
                                        <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                        <button type='submit' class='delete-btn'>Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucune commande trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
