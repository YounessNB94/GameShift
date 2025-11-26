<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $pegi = intval($_POST['pegi_rating']); 
    $studio = $_POST['studio'];
    $platform = $_POST['platform'];
    $price = floatval($_POST['price']); 
    $stock = intval($_POST['stock']); 
    $image_url = $_POST['image_url']; 

    $conn = new mysqli('localhost', 'root', 'root', 'GameShift');
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $query = "INSERT INTO games (title, genre, pegi_rating, studio, platform, price, stock, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssidis", $title, $genre, $pegi, $studio, $platform, $price, $stock, $image_url); 
    if ($stmt->execute()) {
        header("Location: products.php"); 
        exit;
    } else {
        echo "Erreur : " . $stmt->error; 
    }
    $stmt->close();
    $conn->close();
}
?>

<form method="POST">
    <label>Nom du produit :</label>
    <input type="text" name="title" required>
    <label>Genre :</label>
    <input type="text" name="genre" required>
    <label>Pegi :</label>
    <input type="number" step="1" name="pegi_rating" required>
    <label>Studio :</label>
    <input type="text" name="studio" required>
    <label>Plateforme :</label>
    <input type="text" name="platform" required>
    <label>Prix :</label>
    <input type="number" step="0.01" name="price" required>
    <label>Stock :</label>
    <input type="number" name="stock" required>
    <label>URL de l'image :</label>
    <input type="url" name="image_url" required> 
    <button type="submit">Ajouter</button>
</form>
