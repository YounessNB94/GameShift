<?php

$dbname = "GameShift";
$username = "root";
$password = "root";
 

$conn = new mysqli($servername, $username, $password, $dbname);

session_start();



// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql_check = "SELECT email FROM newsletter_subscribers WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        $sql_insert = "INSERT INTO newsletter_subscribers (email) VALUES ('$email')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "Merci, vous êtes maintenant inscrit à la newsletter !";
        } else {
            echo "Erreur lors de l'inscription : " . $conn->error;
        }
    } else {
        echo "Cette adresse e-mail est déjà inscrite.";
    }
} else {
    echo "Méthode de requête invalide.";
}

$conn->close();
?>
