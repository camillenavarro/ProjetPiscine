<?php
    session_start();
	$pseudo = isset($_POST["pseudo"]) ? $_POST["pseudo"] : "";
	$mdp = isset($_POST["mdp"]) ? $_POST["mdp"] : "";
	$error = "";
	$trouve = "";
	$confirm = "";
	
	if($pseudo == "") { $error .= "L'identifiant est vide.<br />";}
	if($mdp == "") { $error .= "Le mot de passe est vide.<br />";}
	
	$database = "piscine" ;
	$db_handle = mysqli_connect("localhost", "root", ""); //Connexion au serveur
	$db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 
	
	
	
	if($error == "")
	{
		$SQL = "SELECT * FROM utilisateur WHERE pseudo='$pseudo' OR mail = '$pseudo'";
		$result = $db_handle->query($SQL);
		
		if($result->num_rows != 1) { die ("Cet identifiant n'existe pas !");}
		
		while($recherche = mysqli_fetch_array($result))
		{
			if($mdp != $recherche['mdp'])
			{
				echo "Le mot de passe est incorrect." ;
			}
			$_SESSION['pseudo'] = $pseudo;
			header('Location: profil.php');
		}
	}
	else
		echo "$error";
	
    
?>