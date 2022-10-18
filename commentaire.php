<?php 

// ###### TRAITEMENT DE PHP ######

// ###### Etape 1 - Inclusion du fichier init.php
require_once "./inc/init.php";

// ###### Etape 2 - Traiter les données du formulaire
if (!empty($_POST)) {
    debug($_POST);

    // ETAPE Vérification des données
        if ( empty($_POST['pseudo']) || iconv_strlen( trim($_POST['pseudo']) ) > 30 || iconv_strlen( trim($_POST['pseudo']) ) < 3 ) {
            $errorMessage .= "Le pseudo doit contenir entre 3 et 30 caractères <br>";
        }
        if ( empty($_POST['commentaire']) ) {
            $errorMessage .= "Merci de rentrer un commentaire <br>";
        }
        if ( empty($_POST['note']) ) {
            $errorMessage .= "Merci de rentrer une note <br>";
        }

    // ETAPE de sécurisation des données
        foreach ($_POST as $key => $value ) {
            $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
        } 

    // ETAPE Envoie des données en BDD
        if(empty($errorMessage)){
            $requete = $bdd->prepare("INSERT INTO commentaire VALUES (NULL, :pseudo, :commentaire, :note)");
            $success = $requete->execute([
                ':pseudo' => $_POST['pseudo'], 
                ':commentaire' => $_POST['commentaire'],
                ':note' => $_POST['note'],
            ]);

            if ($success) {
                 $_SESSION['successMessage'] = "Bravo, votre commentaire a été enregistré ! <br>";
            } else {
                $errorMessage = "Erreur lors de l'envoi <br>";
            }
        }
}

// debug($_SESSION);

// ###### AFFICHAGE HTML ###### 
$title = "Commentaire";
require_once RACINE_SITE . "inc/header.php";
?>
    <section id="card">

    <div id="photo">
        <img src="./photos/chaise-style-scandinave-blanc-eclatant-et-hevea.jpg" alt="chaise" id="chair">
    </div>

    <form class="col-3 mx-5  mt-5" action="" method="post" enctype="" id="comment">
        <h1 class="text-center mt-5">Commentaire produit "Chaise USA"</h1>
        <?php require_once RACINE_SITE . "inc/messages.php" ?>

        <label class="form-label mt-3" for="pseudo">Pseudo</label>
        <input class="form-control" type="text" name="pseudo" id="pseudo" value="<?= (isset($_POST['pseudo'])) ? $_POST['pseudo'] : "" ?>">

        <label class="form-label mt-3" for="commentaire">Commentaire</label>
        <textarea class="form-control" name="commentaire" id="commentaire" cols="30" rows="10" value="<?= (isset($_POST['commentaire'])) ? $_POST['commentaire'] : "" ?>"></textarea>

        <div class="mb-3 mt-3">
            <label for="note" class="form-label">Note</label>
            <select id="note" class="form-select" name="note">
                <option value=""></option> 
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <button class="d-block mx-auto btn btn-success mt-4" name="add">Envoyer</button>
    </form>

    </section>
    
<?php
require_once RACINE_SITE . "inc/footer.php";
