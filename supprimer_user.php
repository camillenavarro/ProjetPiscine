<?php
	session_start();
	$pseudo = $_SESSION['pseudo'] ;
	
	//Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
	
	$SQL = "SELECT * FROM utilisateur WHERE pseudo = '$pseudo'";
	$result = $db_handle->query($SQL) ;
	
	while($db_field = $result->fetch_assoc())
	{
		$id_user = $db_field['id_user'];
		$fonction = $db_field['fonction'] ;
	}
	
	if($fonction == "Employe")
	{
		$SQL2 = "DELETE FROM employe WHERE id_user = '$id_user'";
		$db_handle->query($SQL2);
	}
	else
	{
		if($fonction == "Apprenti")
		{
			$SQL3 = "DELETE FROM apprenti WHERE id_user = '$id_user'";
			$db_handle->query($SQL3);
		}
		
		$SQL4 = "DELETE FROM etudiant WHERE id_user = '$id_user'";
		$db_handle->query($SQL4);
	}
	
	$SQL5 = "DELETE FROM profil WHERE id_user = '$id_user'";
	$db_handle->query($SQL5);
	
	$SQL6 = "DELETE FROM contact WHERE id_user = '$id_user' OR id_user_contact = '$id_user'";
	$db_handle->query($SQL6);
	
	$SQL7 = "DELETE FROM media WHERE id_user = '$id_user'";
	$db_handle->query($SQL7);
	
	$SQL8 = "DELETE FROM action WHERE id_user = '$id_user'";
	$db_handle->query($SQL8);
	
	$SQL9 = "DELETE FROM publication WHERE id_user = '$id_user'";
	$db_handle->query($SQL9);
	
	$SQL10 = "DELETE FROM utilisateur WHERE id_user = '$id_user'";
	$db_handle->query($SQL10);
	
	echo "Suppression de $pseudo reussie !";
?>