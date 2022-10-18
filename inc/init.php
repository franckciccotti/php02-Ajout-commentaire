<?php

// DECLARATION DE LA SESSION
session_start();

/* 
    Création de la BDD
        BDD Name :  php_tp_commentaire
        Table Name : commentaire
            Colonnes : 
                id              INT PK AI 
                pseudo          VARCHAR(100)
                commentaire     TEXT
                note            INT
    Moteur de stockage InnoDB
    Interclassement UTF8_general_ci
*/

// 1 - Connexion à la BDD
$sgbd = "mysql";
$host = "localhost";
$dbname = "php_tp_commentaire";
$username = "root";
$password = "";
$options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING ];

try{
    $bdd = new PDO("$sgbd:dbname=$dbname;host=$host", $username, $password, $options);
} catch (Exception $e) {
    die("ERREUR CONNEXION BDD : " . $e->getMessage());
}

// 2 - Initialisation des variables globales
$errorMessage = "";
$successMessage = "";

require_once "functions.php";

// 3- Déclaration de 2 constantes globales. 
define( "RACINE_SITE", str_replace( "\\", "/", str_replace( "inc", "", __DIR__ ) ) );
define("URL", "http://$_SERVER[HTTP_HOST]".str_replace($_SERVER['DOCUMENT_ROOT'], "", RACINE_SITE));

