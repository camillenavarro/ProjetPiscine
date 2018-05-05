<?php
    $etudiant = false ;
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

    $pub = array();
    $m = 0;
	
	$SQL7 = "SELECT * FROM connexion";
    $result7 = $db_handle->query($SQL7);
	
	while ($db_field7 = $result7->fetch_assoc()) 
	{
		$id_co = $db_field7['id_user'];
	}
	
    //Requête SQL et récupération des résultats
    $SQL = "SELECT * FROM utilisateur WHERE id_user='$id_co'";
    $result = $db_handle->query($SQL);
    //Récupération des données
    while ($db_field = $result->fetch_assoc()) 
	{ 
        $id_user = $db_field["id_user"];
		$_SESSION['id_user']=$id_user ;
        $nom = $db_field["nom"];
        $prenom = $db_field["prenom"];
        $mail = $db_field["mail"];
        $genre = $db_field["genre"];
		$fonction = $db_field["fonction"];
		
        //Deux types de fonctions: étudiant ou employé
        if($fonction == "Etudiant" or $fonction == "Apprenti"){
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
    else{
        $photo_fond = "background.png";
    }

    //Récupérer les informations liées aux publications
    $SQL7 = "SELECT * FROM publication WHERE id_user='$id_user'";
    $result7 = $db_handle->query($SQL7);
    
    //Récupération des résultats
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_media= $db_field7["id_media"];   
        $type= $db_field7["type"]; 
        $date_post= $db_field7["date_post"];  
        $texte= $db_field7["texte"];  
        
        if($type == "photo"){
            //Il faut récupérer le nom du fichier de la photo
            $SQL11 = "SELECT * FROM media WHERE id_media ='$id_media'";
            $result11 = $db_handle->query($SQL11);

            //Récupération des résultats
            while ($db_field11 = $result11->fetch_assoc()) {
                $nom_fichier = $db_field11['nom_fichier'];
            }
                    
            $pub[$m] =  'Vous avez ajouté une nouvelle photo ! <br>Date de publication: ' . $date_post . '<br>Description de l\'image: ' . $texte . '<br>' . '<img src="image/' . $nom_fichier . '" width="120px" height="120px" />';
            $m++;
        }
        else {
            $pub[$m] ="Vous avez publié un nouvel évènement !<br>Date de publication: " . $date_post . "<br>Votre texte: " . $texte;  
            $m++;
        }
    }

    //Libérations des résultats de la photo de profil
    $result7->free();

	
    //Libération des résultats
    $result->free();
        
    //Fermeture de la connexion à la BDD
    $db_handle->close();
?> 

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Profil de <?php echo $prenom; ?> <?php echo $nom; ?> </title>
    </head>
    
    <body>
        <!-- Div principal -->
        <div class="conteneur">
            
            <a href="accueil.php"><button>Accueil</button></a>
            <a href="gestion_profil.php"><button>Modifier mon profil</button></a>
            <a href="profil.php"><button>Voir mon profil</button></a>
            <a href="reseau.php"><button>Mon réseau</button></a>
            <a href="notifications.php"><button>Mes notifications</button></a>
            <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a>
            <a href="deconnexion.php"><button>Déconnexion</button></a>
            
            <!-- Type d'utilisateur -->
            <div id="droit">
                <h3>Profil <?php echo $droit; ?></h3>
            </div>
            
            <!-- Colonne de gauche -->
            <div id="profil_gauche">
                <!-- Photo de profil -->
                <div id="photo_profil">
                    <img src="image/<?php echo $photo_profil; ?>" alt="Photo de profil de <?php echo $prenom; ?> <?php echo $nom; ?>" height="200" width="200">
                </div>
            
                <!-- Age -->
                <p id="naissance"> Date de naissance: <?php echo $naissance; ?></p>

                <!-- Fonction -->
                <p id="fonction">
                        <?php echo $fonction; ?> <!-- La fonction : étudiant ou le poste de l'employé -->
                        <?php 
                            if($etudiant == true){ //Alors on affiche les résultats en lien avec un étudiant
                                echo " en " . $etudes . " en " . $annees . "ème année.";
                            }
                        ?>
                </p>

                		
                

                <!-- Fin de la colonne de gauche -->
            </div>
            
            
            <!-- Colonne centrale -->
            <div id="profil_centre">
                <!-- Identité -->
                <p id="identite"><?php echo $prenom; ?> <?php echo $nom; ?></p>

                <!-- Adresse mail -->
                <p id="mail"><a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a></p>
                
                <!-- Etudes et expérience -->
                <div id="etudes">
                    <h2>Parcours scolaire</h2>
                    <p><?php echo $etude_historique; ?></p>
                </div>

                <div id="experience">
                    <h2>Expérience professionnelle</h2>
                    <p><?php echo $experience; ?></p>
                </div>
                
                <!-- Voir le CV -->
                <p><input type="submit" value="Voir le CV"></p>
                <!-- Fin de la colonne centrale -->
            </div>
            
            <!-- Colonne de droite -->
            <div id="profil_droite">
                <!-- Evénements récents -->
                <div id="evenements">
                    <h2>Evénements récents</h2>
                    <?php for($i = sizeof($pub)- 1; $i > -1   ; $i--){ ?>
                        <p>
                            <?php echo $pub[$i]; } ?>
                    </p>
                </div>
                <!-- Fin de la colonne de droite -->
            </div>
        </div>
    </body>

</html>