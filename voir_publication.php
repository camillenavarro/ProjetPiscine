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

  /* //On récupère les infos liées à la publication
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }*/
?>

<html>
    <head>
        <link href="accueil.css" rel="stylesheet"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Mes notifications</title>
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
            
            <div id="notif_centre">
                <!-- Photo de profil -->
                <h2>Mes notifications</h2>
                
        
            </div>
        </ul>
    
    </body>

</html>