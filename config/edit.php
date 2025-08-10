<?php
require_once '../config/database.php';
$pdo = dbConnexion();

// Récupération des données
if (isset($_GET['title']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Tâche introuvable");
    }
} else {
    die("ID invalide");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    header("Location: list_tasks.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier tâche</title>
</head>
<body>
<h2>Modifier la tâche</h2>
<form method="post">
    <label>Titre :</label>
    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br>

    <label>Description :</label>
    <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea><br>

    <label>Statut :</label>
    <input type="text" name="status" value="<?= htmlspecialchars($task['status']) ?>"><br>

    <label>Priorité :</label>
    <input type="text" name="priority" value="<?= htmlspecialchars($task['priority']) ?>"><br>

    <label>Échéance :</label>
    <input type="date" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>"><br>

    <button type="submit">Enregistrer</button>
</form>
</body>
</html>