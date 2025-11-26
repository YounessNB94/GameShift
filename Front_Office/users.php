<?php
require_once 'check_login.php';
session_start();
include 'utils/bdd/database.php';

if (isset($_COOKIE['session_token'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE session_token = ?");
    $stmt->execute([$_COOKIE['session_token']]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>




<!DOCTYPE html>


<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Blog - Utilisateurs</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>

<body>
    
    <?php require_once ('composants/nav.php') ?>

    <main>
        <div>
            <?php
            require_once("utils/bdd/database.php");
            require_once ("utils/fonctions/fonctions_login.php");
            require_once ("utils/fonctions/users_request.php");

            checkIfUserIsLogged();

            $users = getUsers($pdo);

            echo '<div id="user_list">';
            foreach ($users as $user) {
                echo '<a href="user.php?id=' . $user["id"] . '"> Nom : "' . $user['nom'] . '" - Prénom : "' . $user['prenom'] . '" - Email : "' . $user['email'] . '" - Age : "' . $user["age"] . '"</a>';
            }

            echo "</div>";

            $pdo = null;

            ?>
        </div>





        <br>
<br>
<br>
<br>
<br>
<br>

<h1>Bienvenue sur GameShift</h1>

<br>

<p>Découvrez les meilleurs jeux videos du moment </p>

<br>
<br>
<br>

<div class="connecter">
  <a href="register.php"><button>Se connecter</button></a>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<h1>Les jeux de la semaine</h1>









<section class="section_produits">
    <div class="produits">
       
        <div class="carte">
            <div class="img"><img src="C:\Users\wylle\OneDrive\Bureau\projet\img\BMWK.jpg"></div>
            <div class="desc">Black Myth: Wukong (PC)</div>   
            <div class="titre">Jeux</div>   
            <div class="box">
                <div class="prix">69.99$</div>
                <Button class="achat">Acheter</Button>
            </div> 
        </div>
        <div class="carte">
            <div class="img"><img src="C:\Users\wylle\OneDrive\Bureau\projet\img\nba-2k25_hhud.jpg"></div>
            <div class="desc">NBA 2K25 (PC)</div>   
            <div class="titre">Jeux</div>   
            <div class="box">
                <div class="prix">69.99$</div>
                <Button class="achat">Acheter</Button>
            </div> 
        </div>
        <div class="carte">
            <div class="img"><img src="C:\Users\wylle\OneDrive\Bureau\projet\img\BMWK.jpg"></div>
            <div class="desc">Black Myth: Wukong (PC)</div>   
            <div class="titre">Jeux</div>   
            <div class="box">
                <div class="prix">69.99$</div>
                <Button class="achat">Acheter</Button>
            </div> 
        </div>

        <div class="carte">
            <div class="img"><img src="C:\Users\wylle\OneDrive\Bureau\projet\img\BMWK.jpg"></div>
            <div class="desc">Black Myth: Wukong (PC)</div>   
            <div class="titre">Jeux</div>   
            <div class="box">
                <div class="prix">69.99$</div>
                <Button class="achat">Acheter</Button>
            </div> 
        </div>


        <div class="carte">
            <div class="img"><img src="C:\Users\wylle\OneDrive\Bureau\projet\img\BMWK.jpg"></div>
            <div class="desc">Black Myth: Wukong (PC)</div>   
            <div class="titre">Jeux</div>   
            <div class="box">
                <div class="prix">69.99$</div>
                <Button class="achat">Acheter</Button>
            </div> 
        </div>


    

        

    
  
        
    </div>
    <br>
    <br>
    <button id="voirPlusButton">Voir plus</button>
</section>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>






<?php require_once ('composants/footer.php') ?>






    </main>

    <?php require_once ('composants/footer.php') ?>

</body>

</html>