<?php
	session_start() ;
	$pseudo = $_SESSION['pseudo'] ;
	$cv = isset($_FILES['uploadFile']['name']) ? $_FILES['uploadFile']['name'] : "" ;
	$error = "" ;
	
	if($cv == "") { $error .= "Vous n'avez pas choisi de fichier ou ce fichier est introuvable.<br />" ; }
	
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
	
		$SQL2 = "SELECT id_cv FROM profil WHERE id_user = '$id_user' "; 
		$result2 = $db_handle->query($SQL2) ;
	
		while($db_field2 = $result2->fetch_assoc())
		{
			$id_cv = $db_field2['id_cv'];
		}
		
		if($id_cv != NULL)
		{
			$SQL3 = "UPDATE cv SET nom_fichier = '$cv' WHERE id_cv = '$id_cv'" ;
			$db_handle->query($SQL3);
		}
		else
		{
			$SQL4 = "SELECT COUNT(id_cv) FROM cv" ;
			$result4 = $db_handle->query($SQL4);
			
			while($db_field4 = $result4->fetch_assoc())
			{
				$id = $db_field4['COUNT(id_cv)'] + 1;
			}
			
			$SQL5 = "INSERT INTO cv VALUES ('$id', '$cv')";
			$db_handle->query($SQL5);	

			$SQL6 = "UPDATE profil SET id_cv = '$id' WHERE id_user = '$id_user' ";
			$db_handle->query($SQL6) ;
		}
        
        header("Location: gestion_profil.php");
	}
	else
		echo "$error";
?>