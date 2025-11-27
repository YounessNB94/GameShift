<?php

session_start(); 

require_once 'utils/bdd/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailerANDvortex/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $verification_token = bin2hex(random_bytes(32)); 
    $is_verified = 0;
    $is_verified_mail = 0;

    
    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
     
        $checkUser  = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $checkUser ->execute(['email' => $email]);
        
        if ($checkUser ->rowCount() > 0) {
            echo "Cet email est déjà utilisé.";
        } else {
          
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name, age, address, verification_token, is_verified, is_verified_mail) VALUES (:username, :email, :password, :first_name, :last_name, :age, :address, :verification_token, :is_verified, :is_verified_mail)");
            
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password, 
                'first_name' => $first_name,
                'last_name' => $last_name,
                'age' => $age,
                'address' => $address,
                'verification_token' => $verification_token,
                'is_verified' => $is_verified,
                'is_verified_mail' => $is_verified_mail
            ]);


            $password_error = '';

    if (strlen($password) < 6) {
        $password_error .= "Le mot de passe doit contenir au moins 6 caractères. ";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $password_error .= "Il manque une majuscule. ";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $password_error .= "Il manque un chiffre. ";
    }
    if (!preg_match('/[\W_]/', $password)) { 
        $password_error .= "Il manque un caractère spécial. ";
    }



            $mail = new PHPMailer(true);
            try {
                
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'wyll509@gmail.com'; 
                $mail->Password = 'htdj grqu nxnf lfxy';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

              
                $mail->setFrom('wyll509@gmail.com', 'Admin');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Vérification de votre compte';
                $verification_link = "http://localhost/gameShift/Front_Office/verifier_email.php?email=" . urlencode($email) . "&token=" . $verification_token;
                $mail->Body = "Cliquez sur ce lien pour vérifier votre compte : <a href='$verification_link'>Vérifier mon compte</a>";

                $mail->send();
                echo "Un email de vérification a été envoyé &agrave votre adresse.";
            } catch (Exception $e) {
                echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
 </head>
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


input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"] {
    width: 100%; 
    padding: 10px; 
    margin-bottom: 15px; 
    border: 1px solid #333; 
    border-radius: 4px; 
    background-color: #2a2a2a; 
    color: #ffffff; 
}


input[type="submit"] {
    background-color: #6200ea; 
    color: #ffffff; 
    border: none; 
    padding: 10px; 
    border-radius: 4px; 
    cursor: pointer; 
    transition: background-color 0.3s; 
}


input[type="submit"]:hover {
    background-color: #3700b3; 
}
    </style>
<body>
<header>
<?php require_once ('composants/nav.php') ?>
    </header>
<br>
<br>
<br>
<br>
    <h2>Formulaire d'inscription</h2>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>
       
        <label for="confirm_password">Confirmer le mot de passe :</label>
<input type="password" id="confirm_password" name="confirm_password" required><br>

        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Nom :</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="age">Âge :</label>
        <input type="number" id="age" name="age" required><br>

        <label for="address">Adresse :</label>
        <input type="text" id="address" name="address" required><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>