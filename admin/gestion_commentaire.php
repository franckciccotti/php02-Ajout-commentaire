<?php 
require_once "../inc/init.php";

// if (!isAdmin()) {
//     header("location:../profil.php");
//     exit;
// }
// unset($_SESSION['user']);
// debug($_SESSION);
// debug($_GET);

// Etape de SUPPRESSION
if( isset($_GET['action']) && $_GET['action'] === "supprimer" ){    
       $requete = $bdd->prepare("DELETE FROM commentaire WHERE id = :id");
       $success = $requete->execute([
        ':id' => $_GET['id']
       ]);
            if ($success) {
                $successMessage = "Le commentaire à bien été supprimé ! <br>";
            } else {
                $errorMessage = "Erreur lors de la suppression du commentaire n°$_GET[id] <br>";
            }
}

// Etape de MODIFICATION
if ( isset($_GET['action']) && $_GET['action'] === "modifier" ) {
    // debug($_GET);
    // Récupération des données de l'utilisateur sélectionné
    $requete = $bdd->prepare("SELECT * FROM commentaire WHERE id = :id");
    $requete->execute(['id' => $_GET['id']]);
    $commentaire_modif = $requete->fetch(PDO::FETCH_ASSOC);

    // On vérifie si le formulaire de modification a été envoyé
    if(!empty($_POST)){

        // Echappement des données
        dataEscape();

        // Vérifier l'intégrité données
        if ( empty($_POST['commentaire']) ) {
            $errorMessage .= "Merci de rentrer un commentaire <br>";
        }
        // if ( empty($_POST['note']) ) {
        //     $errorMessage .= "Merci de rentrer une note <br>";
        // } 

        // Si je n'ai pas de messages d'erreur alors je peux faire la modification en BDD
        if(empty($errorMessage)){
            $requete = $bdd->prepare("UPDATE commentaire SET commentaire = :commentaire WHERE id = :id");
            $success = $requete->execute([ 
                // 'pseudo' => $_POST['pseudo'],
                'commentaire' => $_POST['commentaire'],
                // 'note' => $_POST['note'],
                'id' => $commentaire_modif['id']
            ]);
            if ($success) {
                $successMessage = "Le commentaire a bien été modifié <br>";
            } else {
                $errorMessage = "Erreur lors de la modification <br>";
            }
        }
    }
}

$commentaires = getDataFromTable($bdd, 'commentaire');

$title = "Gestion Commentaire";
require_once RACINE_SITE . "inc/header.php";
?>

    <?php require_once RACINE_SITE . "inc/messages.php" ?>

    <h1 class="text-center mt-5" >Gestion des Commentaires</h1>

    <div class="my-3">
        Nombre de commentaire : <span class="badge bg-danger"><?= $commentaires->rowCount() ?></span>
    </div>
  <!-- Affichage des données -->
    <table class="table table-striped table-hover table-bordered">

        <thead>
            <tr>
                <!-- <th>ID Commentaire</th> -->
                <th>Pseudo</th>
                <th>Commentaire</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <!-- Affichage des utilisateurs -->
            <?php 
                while($commentaire = $commentaires->fetch(PDO::FETCH_ASSOC)){
                   echo "<tr>";
                            foreach($commentaire as $i => $v){   
                                if ($i != "id") { 
                                    echo "<td>$v</td>";
                                }
                            }
                        ?>
                        <td class="d-flex justify-content-around">
                            <a href="?action=modifier&id=<?= $commentaire['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="gestion_commentaire.php?action=supprimer&id=<?= $commentaire['id'] ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer ce commentaire ?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php 
                } 
            ?>
        </tbody>

    </table>

    <?php if ( isset($_GET['action']) && $_GET['action'] === "modifier" ) { ?>
        <h4 class="text-center text-warning mt-6">Modifiez ici le commentaire</h4>

        <?php require_once "../inc/messages.php" ?>

        <form class="col-md-6 mx-auto" action="" method="post">

            <label class="form-label mt-3" for="pseudo">Pseudo</label>
            <input class="form-control" type="text" name="pseudo" id="pseudo" value="<?= $commentaire_modif['pseudo']?>" disabled>

            <label class="form-label mt-3" for="commentaire">Commentaire</label>
            <textarea class="form-control" name="commentaire" id="commentaire" cols="30" rows="10" value="<?= $commentaire_modif['commentaire'] ?>"></textarea>

            <button class="btn btn-warning d-block mx-auto my-4">Modifier</button>

        </form>

    <?php } ?>

<?php

require_once RACINE_SITE . "inc/footer.php";

