<?php
	session_start();
	
	$pseudo = array();
	$id_user = array();
	$fonction = array();
	$naissance = array();
	$genre = array();
	$nom_photo = array();
	$reseau = array();
	$etudes = array();
	$annees = array();
	$entreprise = array();
	$poste = array();
	$i = 0;
	
	$nom = isset($_POST["nom"]) ? $_POST["nom"] : "";
	$prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
	$error = "";
	
	if($nom == "") { $error .= "Veuillez rentrer un nom.<br />"; }
	if($prenom == "") { $error .= "Veuillez rentrer un prénom.<br />"; }
	
	if($error != "")
	{
		die($error);
	}
	
	//Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 
    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');
	
	$SQL = "SELECT * FROM utilisateur WHERE nom = '$nom' AND prenom = '$prenom'" ;
	$result = $db_handle->query($SQL);
	
	while($db_field = $result->fetch_assoc())
	{
		$pseudo[$i] = $db_field['pseudo'];
		$id_user[$i] = $db_field['id_user'];
		$fonction[$i] = $db_field["fonction"];
		$genre[$i] = $db_field["genre"];
		$i++;
	}
	
	for($i = 0; $i < sizeof($pseudo) ; $i++)
	{
		if($fonction[$i] != "Employe")
		{
			$SQL3 = "SELECT * FROM etudiant WHERE id_user = '$id_user[$i]'";
			$result3 = $db_handle->query($SQL3);
			
			while($db_field3 = $result3->fetch_assoc())
			{
				$etudes[$i] = $db_field3["etudes"];
				$annees[$i] = $db_field3["annees"];
			}
			if($fonction[$i] == "Apprenti")
			{
				$SQL4 = "SELECT * FROM apprenti WHERE id_user = '$id_user[$i]'";
				$result4 = $db_handle->query($SQL4);
				
				while($db_field4 = $result4->fetch_assoc())
				{
					$entreprise[$i] = $db_field4["entreprise"];
				}
				
				if($genre[$i] == "femme") { $fonction[$i] = "Apprentie"; }
			}
			else
			{ 
				if($genre[$i] == "femme") { $fonction[$i] = "Etudiante"; } 
			}
		}
		
		if($fonction[$i] == "Employe")
		{
			$SQL3 = "SELECT * FROM employe WHERE id_user = '$id_user[$i]'";
			$result3 = $db_handle->query($SQL3);
			
			while($db_field3 = $result3->fetch_assoc())
			{
				$poste[$i] = $db_field3["poste"];
			}
			
			if($genre[$i] == "femme") { $fonction[$i] = "Employee"; }
		}
		
		
		
		
		$SQL2 = "SELECT * FROM media WHERE id_user = '$id_user[$i]' AND titre = 'Profil'";
		$result2 = $db_handle->query($SQL2);
		
		if($result2->num_rows != 1) 
		{ 
			if($genre == "femme") { $nom_photo[$i] = "avatar_femme.png" ;}
				else { $nom_photo[$i] = "avatar_homme.png" ;}
		}
		else
		{
			while($db_field2 = $result2->fetch_assoc())
			{
				$nom_photo[$i] = $db_field2['nom_fichier'] ;
			}
		}
	}
	
?>

<html>
	<head>
		<title>Recherche de <?php echo $prenom;?> <?php echo $nom;?></title>
		<meta charset = "uft-8" />
	</head>
	<body>
		<a href="accueil.php"><button>Accueil</button></a>
        <a href="gestion_profil.php"><button>Modifier mon profil</button></a>
        <a href="profil.php"><button>Voir mon profil</button></a>
        <a href="reseau.php"><button>Mon réseau</button></a>
        <a href="notifications.php"><button>Mes notifications</button></a>
        <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a>
        <a href="deconnexion.php"><button>Déconnexion</button></a>
		
		<h2>Recherche de <?php echo $prenom; ?> <?php echo $nom; ?>
		
		<table>
		<tbody>
			<?php 
				for($i = 0 ; $i < sizeof($pseudo) ; $i ++)
				{ 
			?>
			<tr>
				<td>
				<div id="photo_profil">
                    <img src="image/<?php echo $nom_photo[$i]; ?>" alt = "<?php echo $nom_photo[$i]; ?>" height="100" width="100">
                </div>
				</td>
				<td>
				<?php echo $prenom; ?> "<?php echo $pseudo[$i]; ?>" <?php echo $nom; ?>
				<br>
				<?php echo $fonction[$i]; ?> 
				<?php if($fonction[$i] == "Etudiant" || $fonction[$i] == "Etudiante") { ?> en <?php echo $etudes[$i]; ?> en <?php echo $annees[$i]; ?> e année. <?php } ?>
				<?php if($fonction[$i] == "Employe" || $fonction[$i] == "Employee") { ?> comme <?php echo $poste[$i]; ?>.<?php } ?>
				<?php if($fonction[$i] == "Apprenti" || $fonction[$i] == "Apprentie") { ?> en <?php echo $etudes[$i]; ?> en <?php echo $annees[$i]; ?> e année dans l'entreprise <?php echo $entreprise[$i]; ?>.<?php } ?>
				<br>
				<?php 
                    array_push($reseau, $pseudo[$i]);
				?>
				<form action="profil_reseau.php" method="post">
                        <input type="submit" value="Voir le profil" name="<?php echo $i;?>">
                </form>
			</tr>
			<?php
				}
			?>
		</tbody>
		</table>
		<?php $_SESSION['pseudo'] = $reseau; ?>
	</body>
</html>