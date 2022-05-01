<?php 
    session_start();



    define("DBUSER", "root");
    define("DBPASS", "");
    $pdo = new PDO("mysql:host=localhost; dbname=facebook; charset=utf8", DBUSER, DBPASS);

    if(!empty($_POST["Email"]) && !empty($_POST["Password"])){
    // Si les champs du formulaire ne sont pas vides alors ont peut traiter la demande de connexion

        $mail = htmlspecialchars($_POST["Email"]);
        $password = htmlspecialchars($_POST["Password"]);
        // htmlspecialchars est une fonction PHP qui permet de convertir les caractères spéciaux en entités html
        // Cela nous permet de nous prémunir des failles XSS



        //Vérification syntaxe de l'adresse email
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
    
            // on fait un message d'erreur dans l'URL
            header("location:login.php?message=le format de votre adresse email n'est pas valide");
            exit();

        }


        // Inutile : requete pour vérifier la concordance des MDP sans rien d'autre
        // $requeteMdp = $pdo->prepare("SELECT * FROM identifiant WHERE adresse_mail = ?");
        // $requeteMdp->execute([$mail]);
        // $user5 = $requeteMdp->fetch();
        // if (!password_verify($password, $user5["mdp"])) {

        //     echo "Le mot de passe est invalide";
        // };



        $requete = $pdo->prepare("SELECT * FROM identifiant WHERE adresse_mail = ?");
        $requete->execute(array($mail));
    
        while($user = $requete->fetch()){

            if(password_verify($password, $user["mdp"])){
            // si le mot de passe donné dans le formulaire correspond au mot de passe de l'utilisateur en bdd (bdd = base de données) (version hashé)
                
            // if($password == $user["mdp"]){
            // ancienne version quand le mot de passe n'était pas hashé 

                $_SESSION["connect"] = 1;
                $_SESSION["User"] = $user["adresse_mail"];

                if(isset($_POST["memoriser"])){
                    setcookie("Id", $user["id_identifiant"], time()+365*24*3600, null, null, false, true);
                    setcookie("Email", $user["adresse_mail"], time()+365*24*3600, null, null, false, true);
                }

                header("location:index.php");
                exit();
                

            } else {
                header("location:login.php?message=le mot de passe saisi est incorrect");
                exit();
            }

        }
    }

?>
    
    



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>facebook connexion</title>
</head>
<body>


<figure class="header">
    <img src="image/facebook logo.png" alt="facebook">
    <figcaption>Avec Facebook, partagez et restez en contact avec votre entourage.</figcaption>
</figure>

<div class="wrapper">

    <section class="seConnecter">

        <form action="login.php" method="post">

            <?php if(isset($sms)){?>
                <p> <?php echo $sms; ?> </p>
            <?php } ?>

            <?php 
                if(isset($_GET["message"])){
                    echo "<div class='messageErreur'>" .htmlspecialchars($_GET["message"]) ."</div>";
                }
            ?>

            <p>
                <label>
                    <input class="email" type="email" name="Email" placeholder="Adresse e-mail ou numéro de tél." size="30">
                </label>
            </p>
            <p>
                <label>
                    <input class="mdp" type="password" name="Password" placeholder="Mot de passe" size="30">
                </label>
            </p>

            <p class="bouton"> &nbsp;
                <input class="boutonConnexion" type="submit" name="Submit" value ="Se connecter">
            </p>

        </form>


        <div>
            <a class="mdpOubli" href="">Mot de passe oublié ?</a>
        </div>

        <div class="ligne"></div>

        <div>
            <a class="creerCompte" href="creerCompte.php">Créer nouveau compte</a>
        </div>


        <p class="lienBasDePage">
            <a href="">Créer une Page</a> pour une célébrité, une marque ou une entreprise.
        </p>

    </section>

</div>  


</body>
</html>

