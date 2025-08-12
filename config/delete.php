<?php
session_start(); // démarre une session car la suppression va générer une requête POST
require_once '../config/database.php'; // connexion à la db dans laquelle se trouve la table tasks

$errors = [];
$message = "";

// verification de l'existence de l'id dans l'url généré par la request get
// Verification du caractére numérqiue de l'ID pour coorespondre avec la format ID de la db 
// si au moins une de ces conditions ne sont pas vérifiées, message d'errur généré, fin de l'execution et redirection vers index.php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $errors[] = "ID de tâche invalide.";
    header("Location: ../public/index.php");
    exit;
}

if (isset($_GET['id'])) { // quand on clique sur le btn supprimer associé à un ID qui correspond à une tâche
 
    $id = (int) $_GET['id']; // conversion de l'Id en un nombre entier avec (int) pour sécuriser l'injection sql

        if ($_SERVER['REQUEST_METHOD'] === "POST") { // confirmation de la suppression de la tâche
               $pdo = dbConnexion(); // execution de la fonction qui permet de créer et retourner une connexion à la db

            //execution de la requete delete pour la tâche (id) selectionnée
             $delateTask = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
             $delateTask->execute(['id' => $id]);
             
            //message de confirmation de la suppresion et retour à index.php
             $message = "Les modifications sont enregistrées";
              // $_SESSION['message'] = "La tâche a bien été supprimée.";
             header("Location: ../public/index.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer la tâche</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<?php
      include '../includes/header.php';
 ?>
 <h2 class="h2">Supprimer une tâche</h2>
     <form method="post" class="formDelete">
             <p> Confirmez-vous la suppresion de la tâche : </p>
        <div>
            
            <button type="submit" class="buttonConfirm">Confirmer</button>
            <a class="buttonCancel" href="../public/index.php" >Annuler</a>

        </div>
    </form>

  <?php
      include '../includes/footer.php';
    ?>
</body>
</html>