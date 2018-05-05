<?php
	
	session_start() ;
	$texte = isset($_POST["comm"]) ? $_POST["comm"] : "";
	$action = $_POST["action"];
	$id_pub = $_SESSION['id_pub'];
	
	//Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!");
	
    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');
	
    //Récupération de l'id de l'utilisateur connecté
    $SQL = "SELECT id_user FROM connexion";
    $result = $db_handle->query($SQL);
	
    while ($db_field = $result->fetch_assoc()) 
	{ 
        $id_user = $db_field["id_user"];
    }
	
	if($action == "Aimer")
	{
		$SQL2 = "SELECT * FROM action WHERE id_pub = '$id_pub' AND id_user = '$id_user' AND type = 'aime'" ;
		$result2 = $db_handle->query($SQL2);
		
		//Si le gars aime déjà alors cliquer sur "Aimer" fait qu'il n'aime plus la publication
		if($result2->num_rows == 1)
		{
			$SQL3 = "DELETE FROM action WHERE id_pub = '$id_pub' AND id_user = '$id_user' AND type = 'aime'" ;
			$db_handle->query($SQL3);
		}
		//Si le gars n'aime pas encore alors cliquer sur "Aimer" fait qu'il aime la publication
		else
		{
			$SQL3 = "INSERT INTO action (id_pub,id_user,type) VALUES ('$id_pub','$id_user','aime')" ;
			$db_handle->query($SQL3);
		}
	}
	
	if($action == "Commenter")
	{
		$SQL2 = "INSERT INTO action (id_pub,id_user,type,texte) VALUES ('$id_pub','$id_user','commentaire', '$texte')" ;
		$db_handle->query($SQL2);	
	}
	
	if($action == "Partager")
	{
		$SQL2 = "INSERT INTO action (id_pub,id_user,type) VALUES ('$id_pub','$id_user','partage')" ;
		$db_handle->query($SQL2);
	}
	
	header("Location: accueil.php");
?>
