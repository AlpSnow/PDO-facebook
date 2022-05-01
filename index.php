<?php 
    session_start(); 
    // Ceci va démarrer une nouvelle session, ou reprendre une session déjà existante
    // Suivant la superglobales PHP utilisé, toutes les informations de la session seront gardées en mémoire via différentes manières (cookies, serveurs etc..)

    if(!isset($_SESSION["User"])){
    // $_SESSION est une superglobale, c'est une varibale interne à PHP toujours disponible quelque soit le contexte (globale ou locale)
    // Le terme "superglobales" signifie que ces variables sont disponibles dans n'importe quel 
    // script PHP : autrement dit, il est inutile de vérifier si elles existent (avec la fonction isset(), 
    // par exemple), elles sont créées automatiquement par le serveur. Néanmoins, elles peuvent 
    // être vides (et le seront si aucune donnée n'est transmise).

    // Toutes les superglobales prennent la forme d'un tableau associatif 

        header("location:login.php");
        exit();
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>
</head>
<body>

    <section>
        <div>
            <!-- Si un utilisateur est connecté, on affiche le contenu de sa session et on lui souhaite la bienvenue  -->
            <p> Bienvenue "<?= $_SESSION["User"] ?>" </p>
            <a href=""> entrer sur facebook avec vos identifiants</a>
            <a href="logout.php"> se déconnecter </a>

        </div>
    </section>
    
</body>
</html>