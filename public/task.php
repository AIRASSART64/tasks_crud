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
$createdDate = $task ['created_at'];
$updatedDate = $task ['updated_at'];
$formatDueDate = " Format de date autorisé : d/m/y";
$formatCreatedDate = " Format de date autorisé : d/m/y";
$formatUpdatedDate = " Format de date autorisé : d/m/y";
if ($dueDate && strtotime($dueDate) !== false) {
    $formatDueDate = date("d/m/Y", strtotime($dueDate));
} 
if ($createdDate && strtotime($createdDate) !== false) {
    $formatCreatedDate = date("d/m/Y", strtotime($createdDate));
} 
if  ($updatedDate && strtotime($updatedDate) !== false) {
    $formatUpdatedDate = date("d/m/Y", strtotime($updatedDate));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task details</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="../assets/scripts.js" defer></script>
</head>

   <?php
    include '../includes/header.php';
    ?>
<body>
    <div class="taskContainer">
    <h2><?= htmlspecialchars($task['title']) ?></h2>
    <label class="status" >Statut : <?= htmlspecialchars($task['status']) ?></label>
    <label class="priority">Priorité : <?= htmlspecialchars($task['priority']) ?></label>
    <p class="bold">Date d'échéance : <?= htmlspecialchars($formatDueDate) ?></p>
    <p class="bold">Déscription : <?= htmlspecialchars($task['description']) ?></p>
    <p>Date de création : <?= htmlspecialchars($formatCreatedDate) ?></p>
    <p>Date de derniére modification : <?= htmlspecialchars($formatUpdatedDate) ?></p>

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
