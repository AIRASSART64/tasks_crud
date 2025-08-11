<?php
require_once '../config/database.php';
$pdo = dbConnexion();

// on se positionne sur toutes les données db associées à la tâche selectionnée dans la liste des tâches et identifiées par un ID  ---
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    //  On appelle toutes les données de la db associées à la tâche selectionnée

    $sqlEdit = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $sqlEdit->execute(['id' => $id]);
    $task = $sqlEdit->fetch(PDO::FETCH_ASSOC);

    // message d'erreur et fin d'execution du code si la tâche ou l'Id n'existent pas dans la db
    if (!$task) {
        die("Tâche introuvable");
    }
    } else {
    die("ID inexistant");
    }

// Traitement des modifications saisies et envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $id = (int) $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];

    $sql = "UPDATE tasks 
            SET title = :title, description = :description, status = :status, priority = :priority, due_date = :due_date 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'description' => $description,
        'status' => $status,
        'priority' => $priority,
        'due_date' => $due_date,
        'id' => $id
    ]);
    
    exit;
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
    <title>Modifier tâche</title>
     <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<?php
      include '../includes/header.php';
 ?>

<h2 class="h2">Modifier la tâche</h2>
<form method="post" class="newTask">
     <div class="input"> 
    <label for="title">Titre (obligatoire)</label>
    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" maxlength="50"  required>
    </div>
    <div class="input">
    <label for="description">Déscription (obligatoire)</label>
    <textarea name="description" maxlength="200" require><?= htmlspecialchars($task['description']) ?> </textarea>
    </div> 
    <div class="input">
                    <label for="status">Selectionnez un statut </label>
                    <select name="status" >
                    <option value="0"> à faire</option>
                    <option value="1">en cours</option>
                    <option value="2" >terminée</option>
                    </select>
    </div>
     <div class="input">
                    <label for="prority">Séléctionner une priorité</label>
                    <select name="priority">
                    <option value="0" >moyenne</option>
                    <option value="1">haute</option>
                    <option value="2" >moyenne</option>
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