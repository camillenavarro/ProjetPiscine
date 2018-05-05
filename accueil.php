<?php
    //Variables 
    $id_contacts = array();
    $id_pub = array();
    $texte_pub = array();
    $detail_pub = array();
    $nom_contact = array();
    $prenom_contact = array();
    $date_post = array();

    $i = 0;
    $j = 0;
    $k = 0;
    $m = 0;
    $save = 0;
    $n = 0;

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


    //Informations liées aux notifications
    //1) Récupérer tous les id des contacts dans la tables contact
    $SQL7 = "SELECT * FROM contact WHERE id_user='$id_user'";
    $result7 = $db_handle->query($SQL7);
    
    //Récupération des résultats
    while ($db_field7 = $result7->fetch_assoc()) {
        $id_contacts[$i] = $db_field7['id_user_contact'] ;
        $i ++ ;  
    }

    //2) Récupérer les informations des notifications de publication
    for($i = 0 ; $i < sizeof($id_contacts) ; $i++)
	{
        //On regarde déjà si l'utilisateur a égénré des notifications
        $SQL11 = "SELECT COUNT(id_user) FROM notif_pub WHERE id_user='$id_contacts[$i]'";
        $result11 = $db_handle->query($SQL11);
            
        while ($db_field11 = $result11->fetch_assoc()) {
            $nombre = $db_field11['COUNT(id_user)'] ;
        }

        //Si il y a au moins un résultat = une notification associée à l'id
        if($nombre > 0){
                $SQL8 = "SELECT * FROM notif_pub WHERE id_user='$id_contacts[$i]'";
                $result8 = $db_handle->query($SQL8);
                $m++;

                //Récupération des résultats
                while ($db_field8 = $result8->fetch_assoc()) {
                    $id_pub[$j] = $db_field8['id_pub'] ;
                    $texte_pub[$j] = $db_field8['texte'] ;
                    
                    //On récupère les noms et prénoms de l'auteur associés aux publications
                    $SQL9 = "SELECT * FROM utilisateur WHERE id_user='$id_contacts[$i]'";
                    $result9 = $db_handle->query($SQL9);

                    //Récupération des résultats
                    while ($db_field9 = $result9->fetch_assoc()) {
                        $nom_contact[$j] = $db_field9['nom'] ;
                        $prenom_contact[$j] = $db_field9['prenom'] ;
                    }
                    
                     for($n = 0 ; $n < sizeof($id_pub) ; $n++)
	               {
                        $SQL10 = "SELECT * FROM publication WHERE id_pub='$id_pub[$n]'";
                        $result10 = $db_handle->query($SQL10);

                        //Récupération des résultats
                        while ($db_field10 = $result10->fetch_assoc()) {
                            $detail_pub[$j] = $db_field10['texte'] ;
                            $date_post[$j] = $db_field10['date_post'];
                        }
                    }

                    $j++;
                }


           
        }    
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
            
            <div id="accueil_droite">
                
                <!-- Publication -->
                <form action="publication.php" method="post">
                <h3>Ecrire une publication</h3>
                <p><textarea name="Pub" cols="40" rows="5" value="Votre texte..."></textarea></p>
                <input type="submit" value="Envoyer" name="Soumettre">
                </form>
                
                <!-- Les notifications -->
                <div id="accueil_notif">
                    <h3>Mes notifications</h3>
                    <!-- On affiche les notifications par contact -->
                    <!-- Ouverture de la boucle for -->
                    <?php for($n = $m ; $n > 0  ; $n--) { ?>
                        <h4><?php echo $prenom_contact[$n]; ?> <?php echo $nom_contact[$n]; ?></h4>
                    
                    <?php for($i = sizeof($id_pub)-1 ; $i > -1  ; $i--) { ?>
                    <p><?php if(($prenom_contact[$n] == $prenom_contact[$i])and ($nom_contact[$n] == $nom_contact[$i])){echo $texte_pub[$i]; ?> de <?php echo $prenom_contact[$i]; ?> <?php echo $nom_contact[$i]; ?> ! <br>  Postée le <?php echo $date_post[$i]; ?> <br> Détails:  <?php echo $detail_pub[$i];} ?></p>
                    <!-- Fermeture de la boucle for -->
                    <?php }} ?>
                </div>
                
                <!-- Les demandes d'amis -->
            <form action = "reception_demande_front.php" method = "post">
				<input type = "submit" value = "Voir les demandes d'amis">
			</form>
            </div>
        
        </div>
    
    </body>

</html>