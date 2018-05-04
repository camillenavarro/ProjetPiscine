<?php
	session_start();
	$pseudo_contact = $_SESSION['pseudo'];
	$relation = $_POST['relation'] ;
	$error = "" ;
	
	if($relation == "Choisir") { $error .= "Vous n'avez pas rentre la relation souhaitee." ; }
	
	if($error == "")
	{
		$database = "piscine"; //Nom de la BDD
		$db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
		$db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
		
		$SQL = "SELECT * FROM connexion" ;
		$result = $db_handle->query($SQL) ;
		
		while($db_field = $result->fetch_assoc())
		{
			$id_moi = $db_field['id_user'];
		}
		
		$SQL2 = "SELECT id_user FROM utilisateur WHERE pseudo = '$pseudo_contact' "; 
		$result2 = $db_handle->query($SQL2);
		
		while($db_field2 = $result2->fetch_assoc())
		{
			$id_contact = $db_field2['id_user'];
		}
		
		if($relation == "Ajouter en ami")
		{
			$SQL3 = "INSERT INTO demande_ami (`id_user`, `id_contact`, `type`) VALUES ('$id_moi','$id_contact','ami')";
			$db_handle->query($SQL3);
		}
		else
		{
			$SQL4 = "INSERT INTO demande_ami (`id_user`, `id_contact`, `type`) VALUES ('$id_moi', '$id_contact', 'collegue')";
			$db_handle->query($SQL4);
		}
		
		header("Location: profil.php");
	}
	else
		echo "$error" ;
	
	
	
?>