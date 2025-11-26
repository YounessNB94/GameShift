<?php

include 'utils/bdd/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stay_logged_in = isset($_POST['stay_logged_in']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_verified_mail'] == 0) {
            echo "Veuillez vérifier votre adresse e-mail.";
            exit;
        }

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email']; 

        if ($stay_logged_in) {
            $session_token = bin2hex(random_bytes(32));
            setcookie("session_token", $session_token, time() + (86400 * 30), "/");

            $stmt = $pdo->prepare("UPDATE users SET session_token = ? WHERE user_id = ?");
            $stmt->execute([$session_token, $user['user_id']]);
        }

        echo "Connexion réussie.";
        header("Location: index.php"); 
        exit;
    } else {
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
       
        body, h2, label, input {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #121212; 
            color: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: black;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px; 
            margin: 0 auto; 
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 8px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); 
        }

        
        label {
            display: block; 
            margin-bottom: 5px; 
        }

        
        input[type="email"],
        input[type="password"] {
            width: 100%; 
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #333; 
            border-radius: 4px; 
            background-color: #2a2a2a; 
            color: #ffffff; 
        }

       
        button {
            background-color: #6200ea;
            color: #ffffff; 
            border: none; 
            padding: 10px;
            border-radius: 4px; 
            cursor: pointer;
            width: 100%; 
            transition: background-color 0.3s; 
        }

       
        button:hover {
            background-color: #3700b3;
        }

      
        a {
            color: #007bff;
            text-decoration: none;
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <?php require_once ('composants/nav.php') ?>
</header>

<main>
    <form action="login.php" method="post">
        <h2>Connexion</h2>
        
        <?php
        if (isset($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        ?>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="checkbox-container">
            <label>
                <input type="checkbox" name="stay_logged_in"> Rester connecté
            </label>
        </div>

        <button type="submit">Se connecter</button>
        <a href="register.php">Vous n'avez pas de compte ? Inscrivez-vous</a>
    </form>
</main>
</body>
</html>
