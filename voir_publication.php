<?php 
    session_start() ;
	$id_pub_user = $_SESSION['id_pub']; //On récupère les index des publications affichées pour l'utilisateur connecté
    $i = 0;

    //On parcours les liens des publications et on regarde laquelle a été choisie 
    for($i = 0 ; $i < sizeof($id_pub_user) ; $i ++)
	{
        if (isset($_POST[$i])) {
            $id_pub = $id_pub_user[$i]; //On sauvegarde l'id de la publication à voir
        }
    }

	$_SESSION['id_pub'] = $id_pub_user;
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 

    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

    //Récupération de l'id de l'utilisateur connecté (pour les j'aime, partager, commentaires)
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }
    
    //On récupère les infos liées à la publication
    $SQL7 = "SELECT * FROM publication WHERE id_pub='$id_pub'";
    $result7 = $db_handle->query($SQL7);

    //On consigne les résultats dans un tableau
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_auteur = $db_field7["id_user"]; //L'id de l'auteur de la publication
        $id_media = $db_field7["id_media"];
        $type = $db_field7["type"];
        $date_post = $db_field7["date_post"];
        $text = $db_field7["texte"];
    }

    //Si c'est une publication photo, on récuypère les données de la phot
    if($type == "photo"){
        //On récupère les infos liées à la photo
        $SQL8 = "SELECT * FROM media WHERE id_media='$id_media'";
        $result8 = $db_handle->query($SQL8);

        //On consigne les résultats dans un tableau
        while ($db_field8 = $result8->fetch_assoc()) { 
            $nom_fichier = $db_field8["nom_fichier"]; 
        }  
    }

    //On récupère maintenant les informations de l'auteur de la publication
    $SQL9 = "SELECT * FROM utilisateur WHERE id_user='$id_auteur'";
    $result9 = $db_handle->query($SQL9);

    //On consigne les résultats dans un tableau
    while ($db_field9 = $result9->fetch_assoc()) { 
        $nom_auteur = $db_field9["nom"]; 
        $prenom_auteur = $db_field9["prenom"];
        $pseudo_auteur = $db_field9["pseudo"];
        $_SESSION['pseudo_auteur'] = $pseudo_auteur;
    }  


?>

<html>
    <head>
        <link href="accueil.css" rel="stylesheet"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Publication de <?php echo $prenom_auteur ?> <?php echo $nom_auteur ?></title>
    </head>
    
    <body>
        <ul class="conteneur">
            
            <ul class="menu">
            <li> <a href="accueil.php"><button>Accueil</button></a></li>
               <li> <a href="gestion_profil.php"><button>Modifier mon profil</button></a></li>
                <li> <a href="profil.php"><button>Voir mon profil</button></a></li>
               <li> <a href="reseau.php"><button>Mon réseau</button></a></li>
               <li> <a href="notifications.php"><button>Mes notifications</button></a></li>
               <li> <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a></li> 
               <li> <a href="deconnexion.php"><button>Déconnexion</button></a></li>  
            </ul>
            
            <div id="voir_publication">
                <h2>Publication de <?php echo $prenom_auteur ?> <?php echo $nom_auteur ?></h2>
                <p><form action="profil_auteur.php" method="post">
                        <input type="submit" value="Voir le profil de <?php echo $pseudo_auteur; ?>" name="<?php echo $i;?>">
                </form></p>
                <p>Postée le <?php echo $date_post; ?><br>
                <?php echo $text ?><br>
                <p><?php
                        if($type == "photo"){
                            echo '<img src="image/' . $nom_fichier . '"/>';
                        }
                    ?></p>
				<form action = "reactions.php" method = "post">

				<input type = "submit" value = "Aimer" name = "0">
				<input type = "submit" value = "Partager" name = "0">
				<table>
					<tr>
						<td>Commentaire : </td>
						<td><input type = "text" name = "comm"></td>
						<td><input type = "submit" name = "0" value = "Commenter"></td>
					</tr>
				</table>
				</form>
            </div>
        </ul>
    
    </body>

</html>