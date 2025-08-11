<?php
    
    require_once '../config/database.php';

    $errors = [];
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
   
        $title = trim(htmlspecialchars($_POST["title"]) ?? '');
        $description = trim(htmlspecialchars($_POST["description"]) ?? '');
        $status = $_POST["status"] ?? '';
        $priority = $_POST["priority"] ?? '';
        $dueDate = $_POST["due_date"] ?? '';
        
  
        if (empty($title)) {
            $errors[] = "Titre à renseigner ";
   
        }elseif (empty($description)) {
            $errors[] = "Déscription à renseigner ";
  
        }elseif (empty($dueDate)) {
            $errors[] = "Date d'échéance à renseigner ";
  
        }

       
        
        if (empty($errors)) {
            //logique de traitement en db
            $pdo = dbConnexion();

            
            $checkTask = $pdo->prepare("SELECT * FROM tasks WHERE title = ?");

        
            $checkTask->execute([$title]);

            //une condition pour vérifier si je recupere quelque chose
            if ($checkTask->rowCount() > 0) {
                $errors[] = "La tâche existe déjà.";
            } else {
        

                //insertion des données en db
        
                $insertTask = $pdo->prepare("
                INSERT INTO tasks (title, description, status , priority, due_date) 
                VALUES (?, ?, ? , ? , ?)
                ");

                $insertTask->execute([$title , $description, $status, $priority, $dueDate]);

                $message = "La nouvelle tâche est enregistrée";
            }
     
        }

        
    }
?>

<!DOCTYPE html>
<html lang="fr">

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
    include '../includes/header.php';
    ?>
    <section>
         <?php foreach ($errors as $error): ?>  
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>

        <?php if (!empty($message)): ?>
        <p class="success"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="newTask">
                <div class="input"> 
                    <label for="title">Titre (obligatoire)</label>
                    <input placeholder="Choisissez le titre de la tâche" type="text" id="title" name="title" maxlength="50" require >
                </div>
                <div class="input">
                     <label for="description">Déscription (obligatoire)</label>
                    <textarea  placeholder="Décrivez la tâche" id="description" name="description" 
                       maxlength="200" require></textarea>
                </div> 
                <div class="input">
                    <label for="status">Selectionnez un statut </label>
                    <select name="status" id="status">
                    <option value="0"> à faire</option>
                    <option value="1">en cours</option>
                    <option value="2" >terminée</option>
                    </select>
                 </div>
                 <div class="input">
                    <label for="prority">Séléctionner une priorité</label>
                    <select name="priority" id="priority">
                    <option value="0" >moyenne</option>
                    <option value="1">haute</option>
                    <option value="2" >moyenne</option>
                    </select>
                 </div>
                 <div class="input">
                    <label for="due_date"> Choisissez une date d'échéance (obligatoire)</label>
                    <input placeholder="due_date" type="date" id="due_date" name="due_date"  require>
               </div>
                <div class="submit">
                    <input class="buttonSend" type="submit" value="Envoyer">
                </div>
            </form>

   </section>
</body>
</html>