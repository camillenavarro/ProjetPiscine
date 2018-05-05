<?php
	session_start();
	$choix = $_POST["choix"] ;
	
    //Déclaration des variables 
    $tab = $_SESSION['id_demande'];
    $index = 0;
    $i = 0;
    for($i = 0 ; $i < sizeof($tab) ; $i ++)
	{
        if (isset($_POST[$i])) {
            $index=$i;
        }
    }
    $id_demande = $tab[$index];
	
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');
    
	$SQL = "SELECT * FROM demande_ami WHERE id_demande = '$id_demande'";
	$result = $db_handle->query($SQL);
	
	while ($db_field = $result->fetch_assoc()) 
	{
		$id_moi = $db_field['id_contact'];
		$id_contact = $db_field['id_user'];
		$type = $db_field['type'];
	}
	
	if($choix == "Accepter")
	{
		$SQL2 = "INSERT INTO contact (id_user,id_user_contact,type,restreint) VALUES ('$id_moi','$id_contact','$type','non')";
		$db_handle->query($SQL2);
		
		$SQL3 = "INSERT INTO contact (id_user,id_user_contact,type,restreint) VALUES ('$id_contact','$id_moi','$type','non')";
		$db_handle->query($SQL3);
	}
	
	$SQL4 = "DELETE FROM demande_ami WHERE id_demande = '$id_demande'";
	$db_handle->query($SQL4);
	
	header("Location: accueil.php");
	
?>