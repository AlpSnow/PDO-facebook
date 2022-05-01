<?php 
    session_start();



    define("DBUSER", "root");
    define("DBPASS", "");
    $pdo = new PDO("mysql:host=localhost; dbname=facebook; charset=utf8", DBUSER, DBPASS);
    // On se connecte à la base de données

    if(!empty($_POST["Email"]) && !empty($_POST["Password"]) && !empty($_POST["Password2"])) {
    // Si les champs du formulaire ne sont pas vides alors ont peut traiter la demande de connexion

        $mail = htmlspecialchars($_POST["Email"]);
        $telephone = htmlspecialchars($_POST["Telephone"]);
        // $telephone = filter_input(INPUT_POST, "Telephone", FILTER_VALIDATE_INT); Ne fonctionne pas avec ce filtre car le nombre du téléphone est trop gros
        
        $mdp = htmlspecialchars($_POST["Password"]);
        $mdpHasher = password_hash($mdp, PASSWORD_DEFAULT); 
        // htmlspecialchars est une fonction PHP qui permet de convertir les caractères spéciaux en entités html
        // Cela nous permet de nous prémunir des failles XSS




        //*? Vérification syntaxe de l'adresse email :
            
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
    
            header("location:creerCompte.php?message=le format de votre adresse e-mail n'est pas valide");
            // on fait un message d'erreur dans l'URL
            exit();
            // On utilise la fonction exit() afin de ne pas continuer le script sans quoi l'adresse email sera tout de même créee même si le format est invalide 

            // on pourrait aussi faire comme ci-dessous. Mais cela n'arreterait pas le script et le compte sera quand même crée. Il faudrait faire un Else pour que cela fonctionne
            //  $message = "le format de votre adresse email n'est pas valide";
        }        



        //*? Vérification que l'adresse email n'est pas déjà utilisée et donc présente dans la base de données (bdd) :

        $requeteDoubleMail = $pdo->prepare("SELECT COUNT(*) AS nbMail FROM identifiant WHERE adresse_mail = ?");
        $requeteDoubleMail-> execute([$mail]);

        while($emailVerification = $requeteDoubleMail->fetch()){

            if($emailVerification["nbMail"] != 0){
                header("location:creerCompte.php?message=l'adresse e-mail saisie est déjà utilisée");
                exit();
            }
        }




        If ($_POST["Password"] === $_POST["Password2"]) {
        // Si les deux mots de passes rentré par l'utilisateur sont identiques (même type et même valeur) alors :

            $sql= $pdo->prepare("INSERT INTO identifiant (adresse_mail, telephone, mdp) VALUES (?, ?, ?)");
            // Une requête préparée nous permet de nous prémunir des failles SQL

            $sql->execute([$mail, $telephone, $mdpHasher]);


            echo "<p> Votre compte a été créé avec succès </p>";
            echo "<a href='index.php'> Retourner à l'accueil </a>";
            exit();
            // Voir ligne 150+ pour afficher un message de succès ou d'erreur. Ici on redirige directement l'utilisateur vers une page vierge avec exit()
            // On pourrait aussi rediriger l'utilisateur vers une nouvelle page, par exemple : header("location:compteValide.php");
            // Puis créer et styliser cette page

        } else {
            $message = "Les mots de passes que vous avez saisis ne correspondent pas";
        }

    } else {  //plus tard faire un else if
        // $message = "<span style='color:red'> Veuillez renseigner les champs obligatoires (e-mail, mot de passe, confirmation du mot de passe) </span>";
    };

    

    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>facebook creer compte</title>
</head>
<body>
   
<div class="header2">
    <h1 class="titreCreationCompte">créer votre compte</h1>
    <p>Veuillez renseigner la totalité des champs obligatoires</p>
</div>

<section class="wrapper formulaire">

    <form action="creerCompte.php" method="post">

        <!-- Première façon d'afficher un message d'erreur : -->
        <?php if(isset($message)){?>
            <p class='messageErreur'> <?php echo $message; ?> </p>
        <?php } ?>

        <!-- Autre façon d'afficher un message d'erreur via l'URL : -->
        <?php 
            if(isset($_GET["message"])){
                echo "<p class='messageErreur'>" .htmlspecialchars($_GET["message"]) ."</p>";
            }
        ?>

        <!-- Voir ligne 150+ pour afficher un message de succès ou d'erreur. -->

        <p>
            <label>
                <input class="email" type="email" name="Email" placeholder="Adresse e-mail" size="30">
                <p class="champs">requis</p>
            </label>
        </p>
        <p>
            <label>
                <input class="email" type="text" name="Telephone" placeholder="Numéro de téléphone" size="30">
                <p class="champs">optionnel</p>
            </label>
        </p>
        <p>
            <label>
                <input class="mdp" type="password" name="Password" placeholder="Créer un mot de passe" size="30">
                <p class="champs">requis</p>
            </label>
        </p>
        <p>
            <label>
                <input class="mdp" type="password" name="Password2" placeholder="Confirmation du mot de passe" size="30">
                <p class="champs">requis</p>
            </label>
        </p>

        <p class="bouton"> &nbsp;
            <input class="boutonConnexion boutonConnexion2" type="submit" name="Submit" value ="créer mon compte">
        </p>

    </form>

</section>

</body>
</html>

<!-- - En cas de message de succès on redirige vers :

header("location:creerCompte.php?success=1&message=bravo vous avez tout fait correctement");
exit();  On n'oublie pas de quitter le script 

- En cas de message de succès on redirige vers :

header("location:creerCompte.php?error=1&message=il y'a une erreur");
exit();  On n'oublie pas de quitter le script 



Affichage dans le HTML :


< ?php 
    if(isset($_GET["error"])){

        if(isset($_GET["message"])){

            echo "<p class='messageErreur'>" .htmlspecialchars($_GET["message"]) ."</p>";
        }

    } else if (isset($_GET["success"])) {

        if(isset($_GET["message"])){

            echo "<p class='messageSucces'>" .htmlspecialchars($_GET["message"]) ."</p>";
        }

    }
?>

Ou directement (comme c'est possible ici)

< ?php 

    if(isset($_GET["error"])){
        echo "<p class='messageErreur'>" .htmlspecialchars($_GET["message"]) ."</p>";

    } else if (isset($_GET["success"])) {
        echo "<p class='messageSucces'>" .htmlspecialchars($_GET["message"]) ."</p>";

    }

?> -->
