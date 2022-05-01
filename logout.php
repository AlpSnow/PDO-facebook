<?php 
    session_start();

    session_unset();
    session_destroy(); // normalement on ne fait pas ça --> session_destroy(). c'est uniquement pour être 100% sûr que ça fonctionne. Unset est la manière classique
    setcookie("Id", "", time()-1);
    setcookie("Email", "", time()-1);
    
    header("location:login.php");
    exit();
?>