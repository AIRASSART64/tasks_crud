<?php
require_once '../config/database.php';

// Récupération et validation du paramètre
$title = $_GET['title'] ?? '';
// if (empty($title)) {
//     echo "Titre de tâche manquant";
//     exit;
// }

$pdo = dbConnexion();
$sql = "SELECT title, description, status, priority, due_date FROM tasks WHERE title = ?";
$requestDb = $pdo->prepare($sql);
$requestDb->execute([$title]);
$task = $requestDb->fetch(PDO::FETCH_ASSOC);

// Vérification
if (!$task) {
    echo "Tâche inexistante";
    exit;
}

// Formatage de la date
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
        <a class="editTask" href="edit.php?title=<?= urlencode($task['title']) ?>">Modifier</a>
        <a class="deleteTask" href="delete.php?title=<?= urlencode($task['title']) ?>">Supprimer</a>
    </div>
    </div>
</body>
</html>
