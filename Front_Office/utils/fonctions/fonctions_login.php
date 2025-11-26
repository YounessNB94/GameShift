<?php

function checkIfUserIsLogged() {
    if (!isset($_SESSION["email"]) && empty($_SESSION["email"]) && !isset($_SESSION["id"]) && empty($_SESSION["id"])) {
        header("Location: login.php");
    }
}

function checkFieldsAndRedirect($fieldsArray, $path){
    foreach ($fieldsArray as $field) {
        if (empty($field)) {
            header('Location: '. $path);
        }
    }
}

function disconnectUser() {
    session_destroy();
    header('Location: login.php');
}