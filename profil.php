<?php
    //Déclaration des variables 
     $pseudo = isset($_POST["pseudo"])? $_POST["pseudo"] : ""; //On vérifie si le champ associé au nom de l'employé est vide 
     $error = ""; //Erreur à afficher si l'un des champs du formulaire est vide ou incorrect

    //Vérification des champs vides ou incorrects, affect à error une valeur en conséquence
     if($pseudo == "") { $error .= "Vous n'avez pas rentrer de nom d'utilisateur!<br/>"; }

    //Si la variable error est toujours égale à sa valeur d'initialisation ("") alors il n'y a aucun champ vide
     if ($error != "") { 
        die ("Erreur: $error<br/>"); //On affiche l'erreur en question
     }

    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

    //Requête SQL et récupération des résultats
    $SQL = "SELECT * FROM utilisateur WHERE pseudo='$pseudo'";
    $result = $db_handle->query($SQL);
    
    //Vérification que l'utilisateur existe dans la base de données
    if($result->num_rows != 1){
        die ("Vous avez rentré un nom d'utilisateur invalide ou l'utilisateur n'existe pas!");
    }

    //Récupération des données
    while ($db_field = $result->fetch_assoc()) { 
        $nom = $db_field["nom"];
        $prenom = $db_field["prenom"];
        $mail = $db_field["mail"];
        $fonction = $db_field["fonction"];
        $genre = $db_field["genre"];
        $droit = $db_field["droit"];
    }

    //Libération des résultats
    $result->free();
        
    //Fermeture de la connexion à la BDD
    $db_handle->close();
?> 

<html>
    <head>
        <meta charset="utf-8">
        <title>Profil de <?php echo $prenom; ?> <?php echo $nom; ?> </title>
    </head>
    
    <body>
    </body>

</html>