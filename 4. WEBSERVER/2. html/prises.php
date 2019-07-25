<?php
// Initialize the session
session_start();
 

require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

function mysqlquerry($id,$link){
    $sql = "SELECT State FROM Prises WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $state);
        mysqli_stmt_fetch($stmt);
        if ($state == ""){
            echo("pas d'info dans la BDD");
        }
        else {
            echo($state);
              }
    }
    else { 
        echo ("Je n'ai pas pu récupérer l'état de la prise");        
        }
}




?>
<!DOCTYPE HTML>

<html lang="fr">
    <head>
        <title>Prises - Prise connecté</title> <!-- Met le titre de l'ongles -->
        <link type="text/css" rel="stylesheet" media="all" href="style.css"/> <!-- Liens vers le CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!-- liens Font awsome  pour pouvoir ajouter les icones avec les balises <i>-->
        <meta charset="utf-8"/> <!-- Active le UTF8 pour les accents -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet"><!-- fonts importé depuis google -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
        <script src="./js/mqtt1.js" type="text/javascript"></script>

    </head>
    <body>
        <header> 
            <!-- Voir la page index pour le detail du header -->
            <h1 id="nom_library"> User : <?php echo $_SESSION["username"]; ?></h1>
            <nav class="navbar">
                <ul>
                    <li><a href="accueil.php">Accueil</a></li>
                    <li><a id="active" href="prises.php">Gestion en direct des prises connectées</a></li>
                    <li><a href="programmation.php">Horaire des prises conectées</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </nav>
        </header>
        
        
        <section class="main"> <!-- Création d'une section qui contient tout les éléments genéraux de la page -->
            <h1 class="titres">Listes des Prises Connectées :</h1> <!-- Il s'agit la du titre de la page -->
                        

            <section class="categorie"> <!-- Section qui contient une catégories -->
                <img src="img/prise.png" alt=""> <!-- image de la catégorie -->
                <section class="liste_categorie_content"> <!-- Une section qui contient la description de la catégorie -->
                    <article class="liste_categorie_content">
                         <h4>Prise Connectée 1</h4> <!-- Exemples d'auteurs -->
                        <p>Etat de la prise : <span id="Prise1state"><?php mysqlquerry("1",$link); ?></span></p>
                    <p class="bouton_containter"><a class="bouton" href="#" onclick="publish('Prises/Prise1','ON');">Allumer la prise</a></p> <!-- Bouton explorer la catégorie qui permet de continuer ver la liste des livres et est placé en float -->
                    <p class="bouton_containter"><a class="bouton" href="#" onclick="publish('Prises/Prise1','OFF');">Eteindre la prise</a></p>
                    </article>
                    <article class="liste_categorie_texte"> <!-- texte qui explique la catégorie -->
                        
                       
                        
                        <!-- Déscription de la catégorie -->
                    </article>
                </section>
            </section>
            <section class="categorie"> <!-- Section qui contient une catégories -->
                <img src="img/prise.png" alt=""> <!-- image de la catégorie -->
                <section class="liste_categorie_content"> <!-- Une section qui contient la description de la catégorie -->
                    <article class="liste_categorie_content">
                         <h4>Prise Connectée 2</h4> <!-- Exemples d'auteurs -->
                        <p>Etat de la prise : <span id="Prise2state"><?php mysqlquerry("2",$link); ?></span></p>
                    <p class="bouton_containter"><a class="bouton" href="#" onclick="publish('Prises/Prise2','ON');">Allumer la prise</a></p> <!-- Bouton explorer la catégorie qui permet de continuer ver la liste des livres et est placé en float -->
                    <p class="bouton_containter"><a class="bouton" href="#" onclick="publish('Prises/Prise2','OFF');">Eteindre la prise</a></p>
                    </article>
                    <article class="liste_categorie_texte"> <!-- texte qui explique la catégorie -->
                        
                       
                        
                        <!-- Déscription de la catégorie -->
                    </article>
                </section>
            </section>
            
                    
             
            
        </section>
        
    </body>

</html>
