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
  
        }

       
        
        if (empty($errors)) {
            //logique de traitement en db
            $pdo = dbConnexion();

            
            $checkTask = $pdo->prepare("SELECT * FROM tasks WHERE title = ?");

        
            $checkTask->execute([$title]);

            //une condition pour vérifier si je recupere quelque chose
            if ($checkTask->rowCount() > 0) {
                $errors[] = "Task already created";
            } else {
        

                //insertion des données en db
        
                $insertTask = $pdo->prepare("
                INSERT INTO tasks (title, description, status , priority, due_date) 
                VALUES (?, ?, ? , ? , ?)
                ");

                $insertTask->execute([$title , $description, $status, $priority, $dueDate]);

                $message = "The task is saved";
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
    <title>Tasks list</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php
    include '../includes/header.php';
    ?>
    <section>
        <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                if(!empty($message)) {
                    echo $message;
                }
            ?>
       <form action="" method="POST">
                <div > 
                     <label for="title">Titre</label>
                    <input placeholder="title" type="text" id="title" name="title"  class="input" >
                </div>
                <div >
                     <label for="description">description</label>
                    <input placeholder="description" type="text" id="description" name="description"  class="input">
                </div> 
                <div>
                    <label for="status">Statut</label>
                    <select name="status" id="status">
                    <option value="0"> à faire</option>
                    <option value="1">en cours</option>
                    <option value="2" >terminée</option>
                    </select>
                 </div>
                 <div>
                    <label for="prority">Priorité</label>
                    <select name="priority" id="priority">
                    <option value="0" >moyenne</option>
                    <option value="1">haute</option>
                    <option value="2" >moyenne</option>
                    </select>
                 </div>
                 <div>
                    <label for="due_date">Date d'échéance</label>
                    <input placeholder="due_date" type="date" id="due_date" name="due_date"  class="input">
               </div>
                <div>
                    <input class="buttonSend" type="submit" value="Envoyer">
                </div>
            </form>

   </section>
</body>
</html>