<?php
session_start(); // démarre une session
require_once '../config/database.php'; // connexion à la db dans laquelle se trouve la table tasks

$errors = [];
$message = "";

// verification de la presence de l'id dans l'url généré par la request get
// Verification du caractére numérqiue de l'ID et sécurisation de l'injection sql avec (int) qui convertit tout en nombre entier
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $errors[] = "ID de tâche invalide.";
    header("Location: ../public/index.php");
    exit;
}
if (isset($_GET['id'])) {
 
    $id = (int) $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
               $pdo = dbConnexion();

            //execution de la requete delete pour la tâche (id) selectionnée
             $delateTask = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
             $delateTask->execute(['id' => $id]);

             // $sql = "DELETE FROM tasks WHERE id = :id";
            // $delateTask = $pdo->prepare($sql);
            // $delateTask->execute(['id' => $id]);

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
         <p> Confirmez-vous la suppresion de la tâche: </p>
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