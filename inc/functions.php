<?php

/**
 * Fonction DEV qui permet un affichage clair des données
 */
function debug($variable){
    echo "<pre>";
        print_r($variable);
    echo "</pre>";
}

/**
 * Fonction qui permet d'échapper les données
 */
function dataEscape(){
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
}
function getDataFromTable($pdoObject, $table){
    $requete = $pdoObject->query("SELECT * FROM $table");
    return $requete;
}
