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
        $id_user = $db_field["id_user"];
        $nom = $db_field["nom"];
        $prenom = $db_field["prenom"];
        $mail = $db_field["mail"];
        $genre = $db_field["genre"];
        
        //Deux types de fonctions: étudiant ou employé
        if(($fonction = $db_field["fonction"]) == "Etudiant"){
            $etudiant = true;
            if($genre == "femme"){
                $fonction = "Etudiante";
            }
        }
        else {
            $etudiant = false; //C'est un employé
        }
        
        //Date de naissance optionnelle
        if($db_field["naissance"] == null){
            $naissance = "non précisée.";
        }
        else{
            $naissance = $db_field["naissance"];
        }
        
        $droit = $db_field["droit"];
    }

    //Si la personne est un étudiant
    if($etudiant == true){
        //Requête SQL
        $SQL2 = "SELECT * FROM etudiant WHERE id_user='$id_user'";
        $result2 = $db_handle->query($SQL2);
        
        //Récupération des résultats
        while ($db_field2 = $result2->fetch_assoc()) { 
            $etudes = $db_field2["etudes"];
            $annees = $db_field2["annees"];
        }
        
        //Libérations des résultats
        $result2->free();
    }
    
    //Sinon c'est un employé
    else{
        //Requête SQL
        $SQL3 = "SELECT * FROM employe WHERE id_user='$id_user'";
        $result3 = $db_handle->query($SQL3);
        
        //Récupération des résultats
        while ($db_field3 = $result3->fetch_assoc()) { 
            $fonction = $db_field3["poste"];
        }
        
        //Libérations des résultats
        $result3->free();
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
        <!-- Div principal -->
        <div id="conteneur">
            
            <!-- Photo de profil -->
            <div id="photo">
            </div>
            
            <!-- Age -->
            <div id="naissance">
                <p>Date de naissance: <?php echo $naissance; ?></p>
            </div>
            
            <!-- Fonction -->
            <div id="fonction">
                <p>
                    <?php echo $fonction; ?> <!-- La fonction : étudiant ou le poste de l'employé -->
                    <?php 
                        if($etudiant == true){ //Alors on affiche les résultats en lien avec un étudiant
                            echo " en " . $etudes . " en " . $annees . "ème année.";
                        }
                    ?>
                </p>
            </div>
            
            <!-- Relation -->
            <div id="relation">
            </div>
            
            <!-- Envoyer un message -->
            
            
            <!-- Supprimer du réseau -->
            
            <!-- Identité -->
            <div id="identite">
                <p><?php echo $prenom; ?> <?php echo $nom; ?></p>
            </div>
            
            <!-- Adresse mail -->
            <div id="mail">
                <p><?php echo $mail; ?></p>
            </div>
            
            <!-- Etudes et expérience -->
            <div id="experience">
                <p>Etudes et expérience</p>
            </div>
            
            <!-- Voir le CV -->
            
            <!-- Evénements récents -->
            <div id="evenements">
            </div>
        
        </div>
    </body>

</html>