<?php
	session_start();
    //Variables 
    $id_contacts = array();
    $id_pub = array();
    $texte_pub = array();
    $detail_pub = array();
    $nom_contact = array();
    $prenom_contact = array();
    $date_post = array();
    $id_pub_user = array();

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
        $droit = $db_field["droit"];
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

    $i=0;

    //2) Récupérer toutes les notif de publication
    $SQL8 = "SELECT * FROM notif_pub";
    $result8 = $db_handle->query($SQL8);
    
    //Récupération des résultats
    while ($db_field8 = $result8->fetch_assoc()) {
        $id_pub[$i] = $db_field8['id_pub'] ;
        $id_auteur_pub[$i] = $db_field8['id_user'] ;
        $texte_pub[$i] = $db_field8['texte'] ;
        $i ++ ;  
    }


    //3) On regarde si l'auteur de la notification correspond à un contact de l'utilisateur
    for($i = sizeof($id_pub) - 1; $i > -1  ; $i--)
    {
	array_push($id_pub_user, $id_pub[$i] );
        for($j = sizeof($id_contacts) - 1 ; $j > -1  ; $j--)
        {
            if($id_auteur_pub[$i] == $id_contacts[$j]){
                
                //3) On récupère le nom et prénom de l'auteur de la publication
                $SQL9 = "SELECT * FROM utilisateur WHERE id_user ='$id_auteur_pub[$i]'";
                $result9 = $db_handle->query($SQL9);

                //Récupération des résultats
                while ($db_field9 = $result9->fetch_assoc()) {
                    $nom_contact= $db_field9['nom'];
                    $prenom_contact = $db_field9['prenom'];
                }
                
                //4) Récupère les infos de la publication
                $SQL10 = "SELECT * FROM publication WHERE id_pub ='$id_pub[$i]'";
                $result10 = $db_handle->query($SQL10);

                //Récupération des résultats
                while ($db_field10 = $result10->fetch_assoc()) {
                    $detail_pub = $db_field10['texte'];
                    $date_post = $db_field10['date_post'];
                }
                
                $notif_pub[$m] = $texte_pub[$i] . " de " . $prenom_contact . " " . $nom_contact . "<br>Date de publication: " . $date_post . "<br>Details: " . $detail_pub;  
                $m++;
            }
        }
    }
        
    $_SESSION['id_pub'] = $id_pub_user;

    //Libération des résultats
    $result->free();

    //Fermeture de la connexion à la BDD
    $db_handle->close();
?> 

<html>
    <head>
        <link href="accueil.css" rel="stylesheet"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Accueil</title>
    </head>
    
    <body>
        <ul class="conteneur">
            
            <ul class="menu">
            <li> <a href="accueil.php"><button>Accueil</button></a></li>
               <li> <a href="gestion_profil.php"><button>Modifier mon profil</button></a></li>
                <li> <a href="profil.php"><button>Voir mon profil</button></a></li>
               <li> <a href="reseau.php"><button>Mon réseau</button></a></li>
               <li> <a href=""><button>Mes notifications</button></a></li>
               <li> <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a></li> 
               <li> <a href="deconnexion.php"><button>Déconnexion</button></a></li>  
            </ul>
            
            <div id="accueil_gauche">
                <!-- Photo de profil -->
                <h2>Bonjour, <?php echo $pseudo;?></h2>
                
                <div id="photo_profil">
                   
                      <img src="image/<?php echo $photo_profil; ?>" alt="Photo de profil de <?php echo $prenom; ?> <?php echo $nom; ?>" height="200" width="200">
                  
                </div>
                
                <!-- Identité -->
                <div id="identite">
                    <t>  <p><?php echo $prenom; ?> <?php echo $nom; ?></p></t>
                </div>
                
                <!-- Renseignements supplémentaires -->
            </div>
           
            <!--Possibilité de créer une offre d'emploi pour un admin-->
				<div id="boutons_administrateur">
					<p <?php if($droit != "administrateur") { echo "style='display: none;'"; } else { echo "style='display: block;'"; } ?>>
						<a href = "form_emploi_front.php"><button type = "submit" name="emploi"value = "Poster une offre d'emploi">Poster une offre d'emploi</button></a>
					</p>
				</div>
            <div id="accueil_droite">                
                <!-- Publication -->

                <form method="POST" action="Publication.php" enctype="multipart/form-data">

                
            <p>
                <textarea name="Publi">Votre texte !</textarea></br></br>
                <button type="submit" name="Soumettre">Envoyer une Publication</button></p></br></br>

            <p><input type="file" name="file"></br></br> 
          <button type="submit" name="submit">Enregistrer un fichier</button> </p></br></br>
            </form>
				
				
                 
                <!-- Les notifications -->
                <div id="accueil_notif">
                    <h3>Mur</h3>
                    <?php for($i = 0; $i < sizeof($notif_pub)  ; $i++)
			{ 
			?>
                        <p><?php echo $notif_pub[$i]; ?></p>
				<form action = "reactions.php" method = "post">

				<input type = "submit" value = "Aimer" name = "<?php echo $i; ?>">
				<input type = "submit" value = "Partager" name = "<?php echo $i; ?>">
				<table>
					<tr>
						<td>Commentaire : </td>
						<td><input type = "text" name = "comm"></td>
						<td><input type = "submit" name = "<?php echo $i; ?>" value = "Commenter"></td>
					</tr>
				</table>
				</form>
                    <?php } ?>
                </div>
            
                
                <!-- Les demandes d'amis -->
            <form action = "reception_demande_front.php" method = "post">
				<input type = "submit" name ="ami" value = "Voir les demandes d'amis">
			</form>
            </div>
        
        </ul>
    
    </body>

</html>
