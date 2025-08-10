<?php
require_once '../config/database.php';
$pdo = dbConnexion();


if (isset($_GET['title']) ) {
    // && is_numeric($_GET['id'])
    // $id = (int) $_GET['id'];

    $title = $_GET['title'] ?? '';
    $sql = "DELETE FROM tasks WHERE title = :title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([title]);
    var_dump ($stmt);
}

header("Location: ../public/index.php"); // Redirige vers la liste
exit;