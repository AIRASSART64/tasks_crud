<?php
session_start();
require_once '../config/database.php';

$errors = [];
$message = "";

// on se positionne sur toutes les données db associées à la tâche selectionnée dans la liste des tâches et identifiées par un ID  ---
if (isset($_GET['id'])) {
    $pdo = dbConnexion();
    $id = (int) $_GET['id'];
    //  On appelle toutes les données de la db associées à la tâche selectionnée

    $sqlEdit = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $sqlEdit->execute(['id' => $id]);
    $task = $sqlEdit->fetch(PDO::FETCH_ASSOC);

    // message d'erreur et fin d'execution du code si la tâche ou l'Id n'existent pas dans la db
    if (!$task) {
        $errors[] = "Tâche introuvable";
    }
    } else {
   $errors[] ="ID inexistant";
    }

// Traitement des modifications saisies et envoyées
if (empty($errors)) {


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim(htmlspecialchars($_POST["title"]) ?? '');
    $description = trim(htmlspecialchars($_POST["description"]) ?? '');
    $status = $_POST["status"] ?? '';
    $priority = $_POST["priority"] ?? '';
    $dueDate = $_POST["due_date"] ?? '';

        
        if (empty($title)) {
            $errors[] = "Titre à renseigner ";
   
        }elseif (empty($description)) {
            $errors[] = "Déscription à renseigner ";
  
        }elseif (empty($status)) {
            $errors[] = "Statut à renseigner ";
  
        }elseif (empty($priority)) {
            $errors[] = "Priorité à renseigner ";
  
        }elseif (empty($dueDate)) {
            $errors[] = "Date d'échéance à renseigner ";
  
        }
   if (empty($errors)) {
        $sql = "UPDATE tasks 
            SET title = :title, description = :description, status = :status, priority = :priority, due_date = :due_date 
            WHERE id = :id";
        $editTask = $pdo->prepare($sql);
        $editTask->execute([
        'title' => $title,
        'description' => $description,
        'status' => $status,
        'priority' => $priority,
        'due_date' => $dueDate,
        'id' => $id
    ]);
    //confirmation de la modification de la tâche et retour à la page index.php
      $message = "Les modifications sont enregistrées";
    // header("Location: ../public/index.php");
    // exit;

        }
    }
}
    // Formatage de la date d'échaeance
    $dueDate = $task['due_date'];
    $formatDueDate = "Date invalide";
    if ($dueDate && strtotime($dueDate) !== false) {
    $formatDueDate = date("d/m/Y", strtotime($dueDate));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une tâche</title>
     <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<?php
      include '../includes/header.php';
 ?>

<h2 class="h2">Modifier la tâche</h2>
  <?php foreach ($errors as $error): ?>  
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>

        <?php if (!empty($message)): ?>
        <p class="success"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        
<form method="post" class="newTask">
     <div class="input"> 
    <label for="title">Titre (obligatoire)</label>
    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" maxlength="50"  require>
    </div>
    <div class="input">
    <label for="description">Déscription (obligatoire)</label>
    <textarea name="description" maxlength="200" require><?= htmlspecialchars($task['description']) ?> </textarea>
    </div> 
    <!-- A revoir : les selections du statut et de la priorité ne sont pas prises en compte dans la modification enregistrée dans la db -->
    <div class="input">
                    <label for="status">Selectionnez un statut </label>
                    <select name="status" >
                    <option value="0">Choisir un statut</option>
                    <option value="1">à faire</option>
                    <option value="2" >en cours</option>
                    <option value="3" >terminée</option>
                    </select>
    </div>
     <div class="input">
                    <label for="prority">Séléctionner une priorité</label>
                    <select name="priority">
                    <option value="0" >Choisir une priorité</option>
                    <option value="1">moyenne</option>
                    <option value="2" >haute</option>
                    <option value="3" >basse</option>
                    </select>
     </div>
    <div class="input">
                    <label for="due_date"> Choisissez une date d'échéance (obligatoire)</label>
                    <input type="date" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>" require>
     </div>
    <div class="submit">
                    <input class="buttonSend" type="submit" value="Envoyer">
    </div>
</form>
         

 <?php
      include '../includes/footer.php';
    ?>
</body>
</html>