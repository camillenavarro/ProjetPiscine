<?php
	$database = "piscine" ;
	$db_handle = mysqli_connect("localhost", "root", ""); //Connexion au serveur
	$db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 

    //On récupère l'id du user connecté
    $SQL2 = "SELECT id_user FROM `connexion`";
    $result = $db_handle->query($SQL2);

    while ($db_field = $result->fetch_assoc()) { 
        $id_user = $db_field["id_user"];
    }
    
    //On supprime l'utilisateur connecté de la table connexion pour qu'il se déconnecte
    $SQL = "DELETE FROM connexion WHERE id_user='$id_user'";
    $db_handle->query($SQL);
		
    //Détruire les variables de la session
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
        
    //On redirige vers la page d'accueil
    header('Location: login.html');

?>