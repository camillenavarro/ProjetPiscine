
<?php
	$entreprise = isset($_POST["entreprise"]) ? $_POST["entreprise"] : "" ;
	$type = $_POST["type"] ;
	$poste = isset($_POST["poste"]) ? $_POST["poste"] : "" ;
	$lieu = isset($_POST["lieu"]) ? $_POST["lieu"] : "" ;
	$debut = isset($_POST["debut"]) ? $_POST["debut"] : "" ;
	$fin = isset($_POST["fin"]) ? $_POST["fin"] : "" ;
	$texte = isset($_POST["description"]) ? $_POST["description"] : "" ;
	$error = "" ;
	
	if($entreprise == "") { $error .= "L'entreprise est vide.<br />" ; }
	if($poste == "") { $error .= "Le poste est vide.<br />" ; }
	if($lieu == "") { $error .= "Le lieu est vide.<br />" ; }
	if($debut == "") { $error .= "La date de debut est vide.<br />" ; }
	if($fin == "") { $error .= "La date de fin est vide.<br />" ; }
	if($texte == "") { $error .= "La description est vide.<br />" ; }
	
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
	
	$SQL = "SELECT id_user FROM connexion";
    $result = $db_handle->query($SQL);
	
    while ($db_field = $result->fetch_assoc()) 
	{ 
        $id_user = $db_field["id_user"];
    }
	
	$SQL2 = "INSERT INTO emploi (id_user,entreprise,type,poste,date_debut,date_fin,texte,lieu) VALUES ('$id_user','$entreprise','$type','$poste','$debut','$fin','$texte','$lieu')";
	$db_handle->query($SQL2);
	
	header("Location: accueil.php");

?>

<html>
<head>

	<link href="login.css" rel="stylesheet">
	<title>Erreur</title>

</head>
</html>