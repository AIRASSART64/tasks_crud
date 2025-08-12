<?php
require_once '../config/database.php';

// on se positionne sur toutes les données db associées à la tâche selectionnée dans la liste des tâches et identifiées par un ID  ---
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
//  Requete et execution sql dans la db
$pdo = dbConnexion();
$sql = "SELECT * FROM tasks WHERE id = ?";
$requestDb = $pdo->prepare($sql);
$requestDb->execute([$id]);
$task = $requestDb->fetch(PDO::FETCH_ASSOC);

// Vérification de l'execution de la requete
if (!$task) {
    echo "Tâche inexistante";
    exit;
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
    <title>Task details</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

   <?php
    include '../includes/header.php';
    ?>
<body>
    <div class="taskContainer">
    <h2><?= htmlspecialchars($task['title']) ?></h2>
    <p>Statut : <?= htmlspecialchars($task['status']) ?></p>
    <p>Priorité : <?= htmlspecialchars($task['priority']) ?></p>
    <p>Échéance : <?= htmlspecialchars($formatDueDate) ?></p>
    <p>Déscription : <?= htmlspecialchars($task['description']) ?></p>
    <div class = "buttonTask">
        <a class="return" href="index.php">←  ma liste</a>
        <a class="editTask" href="../config/edit.php?id=<?=$task['id'] ?>">Modifier</a>
        <a class="deleteTask" href="../config/delete.php?id=<?= $task['id'] ?>">Supprimer</a>
    </div> 
    </div>

    <?php
      include '../includes/footer.php';
    ?>
</body>
</html>      
