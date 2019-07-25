<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("refresh:1;url=index.php");
//exit;
?>

<!DOCTYPE HTML>

<html lang="fr">
    <head>
        <title>LOGOUT - Prise connecté</title> <!-- Met le titre de l'ongles -->
        <link type="text/css" rel="stylesheet" media="all" href="style.css"/> <!-- Liens vers le CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!-- liens Font awsome  pour pouvoir ajouter les icones avec les balises <i>-->
        <meta charset="utf-8"/> <!-- Active le UTF8 pour les accents -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet"><!-- fonts importé depuis google -->

    </head>
    <body>
        
        <header> 
            <!-- Voir la page index pour le detail du header -->
            <h1 id="nom_library"> User : ?</h1>
            <nav class="navbar">
                <ul>
                    <li><a href="accueil.php">Accueil</a></li>
                    <li><a href="prises.php">Gestion en direct des prises connectées</a></li>
                    <li><a href="programmation.php">Horaire des prises conectées</a></li>
                    <li><a id="active" href="logout.php">Se déconnecter</a></li>
                </ul>
            </nav>
        </header>
        
        
        <section class="main"> <!-- Création d'une section qui contient tout les éléments genéraux de la page -->
            <h2> Vous avez bien été déconnecté </h2>
                        

            
        </section>
    </body>

</html>
