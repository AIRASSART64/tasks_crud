<?php
    require_once '../config/database.php'; // connexion à la db dans laquelle se trouve la table tasks
     $pdo = dbConnexion();

    // dans la db on accéde à toutes les données de la table tasks d
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
         <!-- boucle pour afficher chaque tâches contenues dans la table tasks -->
        <?php foreach ($tasks as $task) : ?> 
          <!-- formatage d m y de la date due_date  -->
        <?php
            $dueDate = $task['due_date'];
            $formatDate = "Date invalide";
             if ($dueDate && strtotime($dueDate) !== false) {
                 $formatDate = date("d/m/Y", strtotime($dueDate));
                }
         ?>
            <li>
                 <!-- intégration des chacune des valeurs contenues dans la table tasks pour une tâche donnée -->
                    <h3><?= htmlspecialchars($task['title']) ?></h3>
                     <div>
                    <label class="status" > <?= htmlspecialchars($task['status']) ?></label>
                    <label class="priority"> Priorité : <?= htmlspecialchars($task['priority']) ?></label>
                    <label> pour le : <?= htmlspecialchars($formatDate) ?></label>
                    </div>
                    <p><?= htmlspecialchars($task['description']) ?></p>
                    
  <!-- établissement d'un lien html vers task.php  edit.php et delete.php en utilisant le paramêtre unique ID qui coresspond à la tâche selectionnée-->
                    <div class = "button">
                    <a class="consult" href="task.php?id=<?= ($task['id']) ?>">Voir</a>
                    <a class="edit" href="../config/edit.php?id=<?= ($task['id']) ?>">Modifier</a>
                    <a class="delete" href="../config/delete.php?id=<?= ($task['id']) ?>">Supprimer</a>
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



