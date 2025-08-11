<?php
session_start(); // démarre une session
require_once '../config/database.php'; // connexion à la db dans laquelle se trouve la table tasks
$pdo = dbConnexion(); 

// verification de la presence de l'id dans l'url généré par la request get
// Verification du caractére numérqiue de l'ID et sécurisation de l'injection sql avec (int) qui convertit tout en nombre entier
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    //execution de la requete delete pour la tâche (id) selectionnée

    $sql = "DELETE FROM tasks WHERE id = :id";
    $delateTask = $pdo->prepare($sql);
    $delateTask->execute(['id' => $id]);

    //message de confirmation de la suppresion et retour à index.php

    $_SESSION['message'] = "La tâche a bien été supprimée.";
    header("Location: ../public/index.php");
   exit;
}

?>