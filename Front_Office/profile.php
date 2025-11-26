<?php
require_once 'utils/bdd/database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

$query = "SELECT username, email, first_name, last_name, age, address FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_BCRYPT) : null;
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $age = (int) htmlspecialchars(trim($_POST['age']));
    $address = htmlspecialchars(trim($_POST['address']));

    if (empty($username) || empty($email)) {
        $message = "Le pseudo et l'email sont obligatoires.";
    } else {
        $query = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, age = ?, address = ?";
        $params = [$username, $email, $first_name, $last_name, $age, $address];

        if ($password) {
            $query .= ", password = ?";
            $params[] = $password;
        }

        $query .= " WHERE user_id = ?";
        $params[] = $user_id;

        $stmt = $pdo->prepare($query);

        if ($stmt->execute($params)) {
            $message = "Profil mis � jour avec succ�s.";
            $_SESSION['username'] = $username; 
        } else {
            $message = "Erreur lors de la mise � jour.";
        }
    }
}


$stmt->execute([$user_id]);
$games = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        input, button, textarea {
            background-color: #2e2e2e;
            color: #ffffff;
            border: 1px solid #444;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
        }
        img {
            max-width: 100px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<header>
    <?php require_once('composants/nav.php'); ?>
</header>

<div class="container">
<br>
<br>
<br>
<br>
<br>
     
    <h1>Profil utilisateur</h1>
    <p>Bienvenue, <?= htmlspecialchars($user['username']); ?> !</p>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <div class="card">
   <h2>Modifier vos informations</h2>
        <form action="profile.php" method="POST">
            <label for="username">Pseudo :</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>">

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>">

            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password">

            <label for="first_name">Pr&eacutenom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>">

            <label for="last_name">Nom :</label>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>">

            <label for="age">&Acircge :</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($user['age']); ?>">

            <label for="address">Adresse :</label>
            <textarea id="address" name="address"><?= htmlspecialchars($user['address']); ?></textarea>

            <button type="submit">Mettre &agrave jour</button>
        </form>
        <form action="export_pdf.php" method="POST">
            <button type="submit">Exporter au format PDF</button>
        </form>
</div>

    </div>

    <div class="card">
        <h2>Vos jeux achet&eacutes</h2>
        <?php if (!empty($games)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom du jeu</th>
                        <th>Cl&eacute</th>
                        <th>Date d'achat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                         $game_keys = [];
                         foreach ($game_keys as $game): 
                     ?>
                        <tr>
                            <td><?= htmlspecialchars($game['title']); ?></td>
                            <td><?= htmlspecialchars($game['game_key']); ?></td>
                            <td><?= htmlspecialchars($game['purchase_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Vous n'avez achet&eacute aucun jeu.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
