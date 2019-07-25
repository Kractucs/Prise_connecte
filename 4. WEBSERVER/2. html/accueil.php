<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE HTML>

<html lang="fr">
    <head>
        <title>Accueil</title> <!-- Met le titre de l'ongles -->
        <link type="text/css" rel="stylesheet" media="all" href="style.css"/> <!-- Liens vers le CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!-- liens Font awsome  pour pouvoir ajouter les icones avec les balises <i>-->
        <meta charset="utf-8"/> <!-- Active le UTF8 pour les accents -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet"><!-- fonts importé depuis google -->

    </head>
    <body>
        
        <header> 
            <!-- Voir la page index pour le detail du header -->
            <h1 id="nom_library"> User : <?php echo $_SESSION["username"]; ?></h1>
            <nav class="navbar">
                <ul>
                    <li><a id="active"href="accueil.php">Accueil</a></li>
                    <li><a href="prises.php">Gestion en direct des prises connectées</a></li>
                    <li><a href="programmation.php">Horaire des prises conectées</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </nav>
        </header>
        
        
        <section class="main"> <!-- Création d'une section qui contient tout les éléments genéraux de la page -->
            <h1 class="titres">Accueil :</h1> <!-- Il s'agit la du titre de la page -->
                        

            <section class="categorie"> <!-- Section qui contient une catégories -->
                 <!-- image de la catégorie -->
                <section class="liste_categorie_content"> <!-- Une section qui contient la description de la catégorie -->
                    
                    <article class="liste_categorie_texte"> <!-- texte qui explique la catégorie -->
                    
                        
                        <h4>Bienvenue sur notre Site Web destiné à la gestion des Prises Connectés ! </h4> <!-- Exemples d'auteurs -->
                        <p>T'écris ce que tu veux ici pélo</p> 
                        <!-- Déscription de la catégorie -->
                    </article>
                </section>
            </section>
        </section>
    </body>

</html>
