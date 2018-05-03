<?php
    session_start();

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

    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

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

    //Requêtes SQL pour informations du profil
    $SQL4 = "SELECT * FROM profil WHERE id_user='$id_user'";
    $result4 = $db_handle->query($SQL4);
    
    //Récupération des résultats
    while ($db_field4 = $result4->fetch_assoc()) { 
        $id_photo = $db_field4["id_photo"];
        $id_fond = $db_field4["id_fond"];
        $experience = $db_field4["experience"];
        $etude_historique = $db_field4["etude"];    
    }

    //Libérations des résultats du profil
    $result4->free();

    //Variables des photos
    $photo_profil = null;
    $photo_fond = null;

    //Si l'utilisateur possède une photo de profil
    if($id_photo != null){
        //Requête SQL pour la photo de profil
        $SQL5 = "SELECT * FROM media WHERE id_media='$id_photo'";
        $result5 = $db_handle->query($SQL5);
    
        //Récupération des résultats
        while ($db_field5 = $result5->fetch_assoc()) { 
            $photo_profil = $db_field5["nom_fichier"];   
        }

        //Libérations des résultats de la photo de profil
        $result5->free();
    }
    else if($genre == "femme"){
        $photo_profil = "avatar_femme.png";
    }
    else{
        $photo_profil = "avatar_homme.png";
    }
    
    //Si l'utilisateur possède un fond d'écran
    if($id_fond != null){
        //Requête SQL pour la photo de profil
        $SQL6 = "SELECT * FROM media WHERE id_media='$id_fond'";
        $result6 = $db_handle->query($SQL6);
    
        //Récupération des résultats
        while ($db_field6 = $result6->fetch_assoc()) { 
            $photo_fond = $db_field6["nom_fichier"];   
        }

        //Libérations des résultats de la photo de profil
        $result6->free();
    }

    //Libération des résultats
    $result->free();
        
    //Fermeture de la connexion à la BDD
    $db_handle->close();

    //Sauvegarde du pseudo pour les autres pages
    $_SESSION['pseudo'] = $pseudo;
?> 

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gérer mon profil</title>
    </head>
    
    <body>
        <!-- Div principal -->
        <div id="conteneur">
            <h1>Gérer mon profil</h1>
            <!-- Type d'utilisateur -->
            <div id="droit">
                <h3>Profil <?php echo $droit; ?></h3>
            </div>
            
            <!-- Colonne de gauche -->
            <div id="gestion_profil_gauche">
                <!-- Photo de profil -->
                <div id="photo_profil">
                    <img src="image/<?php echo $photo_profil; ?>" alt="Photo de profil de <?php echo $prenom; ?> <?php echo $nom; ?>" height="200" width="200">
                    <p><input type="submit" value="Modifier ma photo" name="modifier_photo_profil"></p>
                </div>
            
                <!-- Informations -->
                <div id="gestion_profil_informations">
                    <h2>Mes informations</h2>
                    <!-- Pseudo -->
                    <p id="pseudo">Pseudo: <?php echo $pseudo; ?></p>
                    
                    <!-- Nom -->
                    <p id="nom"> Nom: <?php echo $nom; ?></p>
                    
                    <!-- Prénom -->
                    <p id="prenom"> Prenom: <?php echo $prenom; ?></p>
                                        
                    <!-- Genre -->
                    <p id="genre">Genre: <?php echo $genre; ?></p>
                    
                    <!-- Date de naissance -->
                    <p id="naissance"> Date de naissance: <?php echo $naissance; ?></p>
                    
                    <!-- Email -->
                    <p id="mail"> E-mail: <?php echo $mail; ?></p>
                    
                    <!-- Fonction -->
                    <p id="fonction">
                            Occupation: <?php echo $fonction; ?> <!-- La fonction : étudiant ou le poste de l'employé -->
                            <?php 
                                if($etudiant == true){ //Alors on affiche les résultats en lien avec un étudiant
                                    echo " en " . $etudes . " en " . $annees . "ème année.";
                                }
                            ?>
                    </p>
                    
                    <!-- Bouton de modification des informations -->
                    <form action="modifier_profil.html" method="post">
                        <input type="submit" value="Modifier mes informations">
                    </form>
                    
                    <!-- Modifier le mot de passe -->
                    <form action="modifier_mdp_front.php" method="post">
                        <input type="submit" value="Modifier mon mot de passe">
                    </form>
                    

                <!-- Fin de la colonne des informations -->
                </div>
                
                <!-- Fin de la colonne de gauche -->
            </div>
            
            
            <!-- Colonne centrale -->
            <div id="gestion_profil_centre">
                <!-- Etudes et expérience -->
                <div id="etudes">
                    <h2>Etudes</h2>
                    <p><?php echo $etude_historique; ?></p>
                </div>

                <div id="experience">
                    <h2>Expérience</h2>
                    <p><?php echo $experience; ?></p>
                </div>

                <!-- Modifier les études -->
                <p><input type="submit" value="Modifier mes études"></p>
                
                <!-- Modifier les expériences -->
                <p><input type="submit" value="Modifier mes expériences"></p>
                
                <!-- Modifier le CV -->
                <p><input type="submit" value="Modifier mon CV"></p>
                <!-- Fin de la colonne centrale -->
            </div>
            
            <!-- Colonne de droite -->
            <div id="gestion_profil_droite">
                <!-- Evénements récents -->
                <div id="evenements">
                    <h2>Evénements récents</h2>
                </div>

                <!-- Image de fond -->
                <div id="photo_fond">
                    <h2>Image de fond</h2>
                    <img src="image/<?php echo $photo_fond; ?>" alt="Fond d'écran de mon profil" height="400" width="500">
                    <p><input type="submit" value="Modifier l'image de fond" name="modifier_photo_fond"></p>
                </div>
                <!-- Fin de la colonne de droite -->
            </div>
        </div>
    </body>

</html>