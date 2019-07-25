<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";



?>
<!DOCTYPE HTML>

<html lang="fr">
    <head>
        <title>Programmation - Prise connecté</title> <!-- Met le titre de l'ongles -->
        <link type="text/css" rel="stylesheet" media="all" href="style.css"/> <!-- Liens vers le CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!-- liens Font awsome  pour pouvoir ajouter les icones avec les balises <i>-->
        <meta charset="utf-8"/> <!-- Active le UTF8 pour les accents -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet"><!-- fonts importé depuis google -->

    </head>
    <body>
        <header> <!-- Voir la page index pour le detail du header -->
            <h1 id="nom_library"> User : <?php echo $_SESSION["username"]; ?></h1>
            <nav class="navbar">
                                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="prises.php">Gestion en direct des prises connectées</a></li>
                    <li><a id="active" href="programmation.php">Horaire des prises conectées</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </nav>
        </header>
        
        
        <section class="main">

<h1 class="titres">Programmation :</h1> <!-- Il s'agit la du titre de la page -->
                <table id="tableau_livre">
                    <thead>
                    <tr>
                        <th>Numéro de la prise</th>
                        <th>Heure</th>
                        <th>Etat</th>
                        <th>Modifier</th>
                    </tr>
                    </thead>
                    <tbody>
        <?php
            $sql = "SELECT * FROM Progra ORDER BY Prise_id,time";
            $stmt = mysqli_prepare($link, $sql);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $id , $prise_id, $time, $state);
                while (mysqli_stmt_fetch($stmt)) {
                    printf ('<tr><td>%s</td><td>%s</td><td>%s</td><td><a href="edit.php?id=%s">Supprimer</a></td></tr>', $prise_id, $time, $state,$id);
                }
                        }
            else { 
                echo ("Je n'ai pas réussi à me connecter à la BDD");        
        }   
        ?>
                        <tr>
                        <form action="edit.php" method="get" id="jul">
                            <td><input type="text" id="prise_id" placeholder="Numéro de prise" name="prise_id"></td>
                            <td><input type="time" id="heure" placeholder="Heure de déclanchement" name="heure"></td>
                            <td><select name="state">
                              <option value="on">ON</option>
                              <option value="off">OFF</option>
                                </select></td>
                            <td><a href="#" onclick="document.getElementById('jul').submit();">Ajouter</a></td>
                        </form>
                        </tr>
                    </tbody>
    	</table
        </section>
        
    </body>

</html>
