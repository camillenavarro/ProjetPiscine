<?php
	$demandeur = array();
	$prenom = array();
	$nom = array();
	$type = array();

	$database = "piscine"; //Nom de la BDD
	$db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
	$db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
	//Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');
	
	$SQL = "SELECT * FROM connexion" ;
	$result = $db_handle->query($SQL) ;
	
	while($db_field = $result->fetch_assoc())
	{
		$id_moi = $db_field['id_user'];
	}
	
	$SQL3 = "SELECT * FROM demande_ami WHERE id_contact = '$id_moi'" ;
	$result3 = $db_handle->query($SQL3);
	
	$i = 0 ;
	while($db_field3 = $result3->fetch_assoc())
	{
		$demandeur[$i] = $db_field3['id_user'];
		$type[$i] = $db_field3['type'];
		$i++;
	}
	
	for($i = 0 ; $i < sizeof($demandeur) ; $i++)
	{
		$SQL2 = "SELECT * FROM utilisateur WHERE id_user = '$demandeur[$i]'";
		$result2 = $db_handle->query($SQL2);
		
		while($db_field2 = $result2->fetch_assoc())
		{
			$prenom[$i] = $db_field2['prenom'];
			$nom[$i] = $db_field2['nom'];
		}
	}
	
	
?>



<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Modifier mon parcours scolaire et mon expérience</title>
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
			
			<h2>Demandes d'amis</h2>
			<p>Vous avez <?php echo sizeof($demandeur) ; ?> demandes d'amis.</p>
			
			<p>
			<?php for($i = 0 ; $i < sizeof($demandeur) ; $i++)
				{
			?>
			<br><?php echo $prenom[$i]; ?> <?php echo $nom[$i]; ?> souhaite devenir votre <?php echo $type[$i]; ?>.
			<br><form action = "reception_demande_back.php">
				<select name = "choix">
					<option>Accepter</option>
					<option>Refuser</option>
				</select>
				<input type ="submit" value = "Valider">
			</form>			
			<?php
				}
			?>
			
			
		</div>
	</body>
</html>