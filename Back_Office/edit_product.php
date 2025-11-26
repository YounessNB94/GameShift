<?php
// $conn = new mysqli('localhost', 'root', 'root', 'GameShift');
    $conn = new mysqli('localhost', 'root', '', 'GameShift');

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$product_id = $_GET['game_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
 

    $query = "UPDATE games SET title = ?, price = ?, stock = ? WHERE game_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdii", $title, $price, $stock, $product_id); 
    if ($stmt->execute()) {
        header("Location: products.php");
    } else {
        echo "Erreur : " . $conn->error;
    }
    $stmt->close();
}

$query = "SELECT * FROM games WHERE game_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
?>

<form method="POST">
    <label>Nom du produit :</label>
    <input type="text" name="title" value="<?php echo $result['title']; ?>" required>
    <label>Prix :</label>
    <input type="number" step="0.01" name="price" value="<?php echo $result['price']; ?>" required>
    <label>Stock :</label>
    <input type="number" name="stock" value="<?php echo $result['stock']; ?>" required>
    <button type="submit">Modifier</button>
</form>
