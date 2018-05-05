<?php
	$id_user = array() ;
	$entreprise = array() ;
	$type = array() ;
	$poste = array() ;
	$debut = array() ;
	$fin = array() ;
	$lieu = array() ;
	$texte = array() ;
	$i = 0 ;
	
	//Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 
    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');
	
	$SQL = "SELECT * FROM emploi" ;
	$result = $db_handle->query($SQL) ;
	
	while($db_field = $result->fetch_assoc())
	{
		
		$id_user[$i] = $db_field['id_user'] ;
		$entreprise[$i] = $db_field['entreprise'] ;
		$type[$i] = $db_field['type'] ;
		$poste[$i] = $db_field['poste'] ;
		$debut[$i] = $db_field['date_debut'] ;
		$fin[$i] = $db_field['date_fin'] ;
		$lieu[$i] = $db_field['lieu'] ;
		$texte[$i] = $db_field['texte'] ;	
	
		$SQL2 = "SELECT * FROM utilisateur WHERE id_user = '$id_user[$i]'" ;
		$result2 = $db_handle->query($SQL2) ;
		
		while($db_field2 = $result2->fetch_assoc())
		{
			$nom[$i] = $db_field2['nom'] ;
			$prenom[$i] = $db_field2['prenom'] ;
		}
		
		$i ++ ;
	}
	
?>

<html>
    <head>
		<link href="accueil.css" rel="stylesheet"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Voir les offres d'emploi</title>
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

			<h2> Offres d'emploi disponibles</h2>
			
			<p>
			<?php for($i = 0 ; $i < sizeof($id_user) ; $i ++)
				{
			?>
			<h4><?php echo $poste[$i]; ?></h4>
			Du <?php echo $debut[$i]; ?> au <?php echo $fin[$i]; ?>.
			<br><?php echo $prenom[$i]; ?> <?php echo $nom[$i]; ?> a publié une offre de <?php echo $type[$i]; ?> pour <?php echo $entreprise[$i]; ?> à <?php echo $lieu[$i]; ?> :
			<br><?php echo $texte[$i]; ?>
			
			<?php
				}
			?>
			</p>

