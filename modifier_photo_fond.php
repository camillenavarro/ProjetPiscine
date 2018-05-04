<?php
	session_start() ;
	$pseudo = $_SESSION['pseudo'] ;
	$photo = isset($_FILES['uploadFile']['name']) ? $_FILES['uploadFile']['name'] : "" ;
	$error = "" ;
	
	if($photo == "") { $error .= "Vous n'avez pas choisi de photo ou cette photo est introuvable.<br />" ; }
	
	if($error == "")
	{
		//Connexion à la BDD
		$database = "piscine"; //Nom de la BDD
		$db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
		$db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
    
		$SQL = "SELECT id_user FROM utilisateur WHERE pseudo = '$pseudo' ";
		$result = $db_handle->query($SQL);
	
		while($db_field = $result->fetch_assoc())
		{
			$id_user = $db_field['id_user'];
		}
	
		$SQL2 = "SELECT id_fond FROM profil WHERE id_user = '$id_user' "; 
		$result2 = $db_handle->query($SQL2) ;
	
		while($db_field2 = $result2->fetch_assoc())
		{
			$id_photo = $db_field2['id_fond'];
		}
		
		if($id_photo != NULL)
		{
			$SQL3 = "UPDATE media SET nom_fichier = '$photo' WHERE id_media = '$id_photo'" ;
			$db_handle->query($SQL3);
		}
		else
		{
			$SQL4 = "SELECT COUNT(id_media) FROM media" ;
			$result4 = $db_handle->query($SQL4);
			
			while($db_field4 = $result4->fetch_assoc())
			{
				$id_media = $db_field4['COUNT(id_media)'] + 1;
			}
			
			$SQL5 = "INSERT INTO media VALUES ('$id_media', '$id_user', 'photo', '$photo', 'Fond', NULL, NULL)";
			$db_handle->query($SQL5);	

			$SQL6 = "UPDATE profil SET id_fond = '$id_media' WHERE id_user = '$id_user' ";
			$db_handle->query($SQL6) ;			
		}
        header("Location: gestion_profil.php");
	}
	else
		echo "$error";
?>