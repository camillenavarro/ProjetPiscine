<?php
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 

    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

    //Récupération de l'id de l'utilisateur connecté
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }
    //Requête SQL et récupération des résultats
    $SQL = "SELECT * FROM utilisateur WHERE id_user='$id_user'";
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
        $pseudo = $db_field["pseudo"];
        $genre = $db_field["genre"];
    }

    //Requêtes SQL pour informations du profil
    $SQL4 = "SELECT * FROM profil WHERE id_user='$id_user'";
    $result4 = $db_handle->query($SQL4);
    
    //Récupération des résultats
    while ($db_field4 = $result4->fetch_assoc()) { 
        $id_photo = $db_field4["id_photo"];
        $id_fond = $db_field4["id_fond"];  
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
    else{
        $photo_fond = "background.png";
    }
    //Libération des résultats
    $result->free();
        
    //Fermeture de la connexion à la BDD
    $db_handle->close();
?> 

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Accueil</title>
    </head>
    
    <body>
        <div class="conteneur">
            
            <div class="menu">
                <a href="accueil.php"><button>Accueil</button></a>
                <a href="gestion_profil.php"><button>Modifier mon profil</button></a>
                <a href="profil.php"><button>Voir mon profil</button></a>
                <a href="reseau.php"><button>Mon réseau</button></a>
                <a href=""><button>Mes notifications</button></a>
                <a href=""><button>Mes offres d'emplois</button></a>
                <a href="deconnexion.php"><button>Déconnexion</button></a>
            </div>
            
            <div id="accueil_gauche">
                <!-- Photo de profil -->
                <h2>Bonjour, <?php echo $pseudo;?></h2>
                <div id="photo_profil">
                        <img src="image/<?php echo $photo_profil; ?>" alt="Photo de profil de <?php echo $prenom; ?> <?php echo $nom; ?>" height="200" width="200">
                </div>
                
                <!-- Identité -->
                <div id="identite">
                    <p><?php echo $prenom; ?> <?php echo $nom; ?></p>
                </div>
                
                <!-- Renseignements supplémentaires -->
            </div>
            
            <div id="acceuil_droite">
            
            </div>
        
        </div>
    
    </body>

</html>