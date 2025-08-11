<?php
    require_once '../config/database.php';

     $pdo = dbConnexion();
     $sql = "SELECT * FROM tasks ";
     $requestDb = $pdo->prepare($sql);   
     $requestDb->execute();
     $tasks = $requestDb->fetchAll(PDO::FETCH_ASSOC);

     
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks list</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
      include '../includes/header.php';
    ?>
    <div class="listContainer">
          <h2> Ma liste </h2>
            
     <ul class="todo-list">
      
        <?php foreach ($tasks as $task) : ?>
        <?php
            $dueDate = $task['due_date'];
            $formatDate = "Date invalide";
             if ($dueDate && strtotime($dueDate) !== false) {
                 $formatDate = date("d/m/Y", strtotime($dueDate));
                }
         ?>
            <li>
                 
                    <h3><?= htmlspecialchars($task['title']) ?></h3>
                    <p><?= htmlspecialchars($task['description']) ?></p>
                    <label> <?= htmlspecialchars($task['status']) ?></label>
                    <label> Priorité : <?= htmlspecialchars($task['priority']) ?></label>
                    <label> pour le : <?= htmlspecialchars($formatDate) ?></label>
                    <div>
                    <a href="task.php?title=<?= urlencode($task['title']) ?>">Voir</a>
                    <a href="edit.php?title=<?= urlencode($task['title']) ?>">Modifier</a>
                    <a href="delete.php?title=<?= urlencode($task['title']) ?>">Supprimer</a>
                    </div>


            </li>
         <?php endforeach; ?>
     </ul>
 </div>

</body>
</html>



