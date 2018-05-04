<?php
	session_start();
	$pseudo_contact = $_SESSION['pseudo'];
	
	
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
	
	$SQL3 = "SELECT * FROM contact WHERE (id_user = '$id_moi' AND id_user_contact = '$id_contact') OR (id_user_contact = '$id_moi' AND id_user = '$id_contact')";
	$result3 = $db_handle->query($SQL3);
	
	while($db_field3 = $result3->fetch_assoc())
	{
		$type = $db_field3['type'];
	}
	
	if($type == "ami")
	{
		$SQL4 = "UPDATE contact SET type = 'collegue' WHERE (id_user = '$id_moi' AND id_user_contact = '$id_contact') OR (id_user_contact = '$id_moi' AND id_user = '$id_contact')" ;
		$db_handle->query($SQL4);
	}
	else
	{
		$SQL5 = "UPDATE contact SET type = 'ami' WHERE (id_user = '$id_moi' AND id_user_contact = '$id_contact') OR (id_user_contact = '$id_moi' AND id_user = '$id_contact')" ;
		$db_handle->query($SQL5);
	}
	
	header("Location: profil.php");
	
?>