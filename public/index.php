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
    <title> Index tasks list</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="../assets/scripts.js" defer></script>
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
                     <div>
                    <label id="status" > <?= htmlspecialchars($task['status']) ?></label>
                    <label id="priority"> Priorité : <?= htmlspecialchars($task['priority']) ?></label>
                    <label> pour le : <?= htmlspecialchars($formatDate) ?></label>
                    </div>
                    <p><?= htmlspecialchars($task['description']) ?></p>
                    <div class = "button">
                    <a class="consult" href="task.php?id=<?= urlencode($task['id']) ?>">Voir</a>
                    <a class="edit" href="../config/edit.php?id=<?= urlencode($task['id']) ?>">Modifier</a>
                    <a class="delete" href="../config/delete.php?id=<?= urlencode($task['id']) ?>">Supprimer</a>
                    </div>


            </li>
         <?php endforeach; ?>
     </ul>
 </div>

  <?php
      include '../includes/footer.php';
    ?>
</body>
</html>



