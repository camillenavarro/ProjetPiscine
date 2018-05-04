<?php
	session_start();
	$id_user = $_SESSION['id_user'];
	$ami = array();
	$collegue = array();
	$nom_ami = array();
	$prenom_ami = array();
	$photo_ami = array();
	$pseudo_ami = array();
	$nom_collegue = array();
	$prenom_collegue = array();
	$photo_collegue = array();
	$pseudo_collegue = array();
	$i = 0 ;
	$j = 0 ;
	
	//Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');
    //Requête SQL et récupération des résultats
    $SQL = "SELECT * FROM contact WHERE id_user = '$id_user'";
    $result = $db_handle->query($SQL);
	
	while ($db_field = $result->fetch_assoc()) 
	{
		if($db_field['type'] == "ami")
		{
			$ami[$i] = $db_field['id_user_contact'] ;
			$i ++ ;
		}
		else
		{
			$collegue[$j] = $db_field['id_user_contact'] ;
			$j++;
		}
	}
	
	for($i = 0 ; $i < sizeof($ami) ; $i++)
	{
		$SQL2 = "SELECT * FROM utilisateur WHERE id_user = '$ami[$i]' ";
		$result2 = $db_handle->query($SQL2);
		
		while ($db_field2 = $result2->fetch_assoc()) 
		{
			$nom_ami[$i] = $db_field2['nom'] ;
			$prenom_ami[$i] = $db_field2['prenom'] ;
			$pseudo_ami[$i] = $db_field2['pseudo'] ;
			
			$SQL2img = "SELECT * FROM media WHERE id_user = '$ami[$i]' AND titre = 'Profil' ";
			$result2img = $db_handle->query($SQL2img);	
			
			if($result2img->num_rows != 1) 
			{ 
				if($db_field2['genre'] == "femme") { $photo_ami[$i] = "avatar_femme.png" ;}
					else { $photo_ami[$i] = "avatar_homme.png" ;}
			}
			else
			{
				while($db_field2img = $result2img->fetch_assoc())
				{
					$photo_ami[$i] = $db_field2img['nom_fichier'] ;
				}
			}
		}
	}
	for($i = 0 ; $i < sizeof($collegue) ; $i++)
	{
		$SQL3 = "SELECT * FROM utilisateur WHERE id_user = '$collegue[$i]' ";
		$result3 = $db_handle->query($SQL3);
		
		while ($db_field3 = $result3->fetch_assoc()) 
		{
			$nom_collegue[$i] = $db_field3['nom'] ;
			$prenom_collegue[$i] = $db_field3['prenom'] ;
			$pseudo_collegue[$i] = $db_field3['pseudo'] ;
			$SQL3img = "SELECT * FROM media WHERE id_user = '$collegue[$i]' AND titre = 'Profil' ";
			$result3img = $db_handle->query($SQL3img);	
			
			if($result3img->num_rows != 1) 
			{ 
				if($db_field3['genre'] == "femme") { $photo_collegue[$i] = "avatar_femme.png" ;}
					else { $photo_collegue[$i] = "avatar_homme.png" ;}
			}
			else
			{
				while($db_field3img = $result2img->fetch_assoc())
				{
					$photo_collegue[$i] = $db_field2img['nom_fichier'] ;
				}
			}
		}
	}
?>
<html>
	<head>
		<title>Projet Piscine</title>
		<meta charset = "uft-8" />
	</head>
	<body>
		<a href=""><button>Accueil</button></a>
        <a href="gestion_profil.php"><button>Modifier mon profil</button></a>
        <a href="profil.php"><button>Voir mon profil</button></a>
        <a href="reseau.php"><button>Mon réseau</button></a>
        <a href=""><button>Mes notifications</button></a>
        <a href=""><button>Mes offres d'emplois</button></a>
        <a href="deconnexion.php"><button>Déconnexion</button></a>
			
		<h1>Réseau</h1> 
		<h2>Amis</h1>
		<table>
		<tbody>
			<?php 
				for($i = 0 ; $i < sizeof($ami) ; $i ++)
				{ 
			?>
			<tr>
				<td>
				<div id="photo_ami">
                    <img src="image/<?php echo $photo_ami[$i]; ?>" alt = "<?php echo $photo_ami[$i]; ?>" height="100" width="100">
                </div>
				</td>
				<td>
				<?php
					echo "$prenom_ami[$i] ";  
					echo " $nom_ami[$i]"; 
				?>
				<br><br>
				<?php 
					$_SESSION['pseudo'] = $pseudo_ami[$i];
				?>
				<a href = "profil.php"><button>Voir le profil</button></a>
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
		</table>
		
		<h2>Contacts professionnel</h2>
		<table>
		<tbody>
			<?php 
				for($i = 0 ; $i < sizeof($collegue) ; $i ++)
				{ 
			?>
			<tr>
				<td>
				<div id="photo_collegue">
                    <img src="image/<?php echo $photo_collegue[$i]; ?>" alt = "<?php echo $photo_collegue[$i]; ?>" height="100" width="100">
                </div>
				</td>
				<td>
				<?php
					echo "$prenom_collegue[$i] ";  
					echo " $nom_collegue[$i]"; 
				?>
				<br><br>
				<?php 
					$_SESSION['pseudo'] = $pseudo_collegue[$i];
				?>
				<a href = "profil.php"><button>Voir le profil</button></a>
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
		</table>
	</body>
</html>