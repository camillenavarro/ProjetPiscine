<?php
    //On récupère le pseudo du compte
    session_start();
    $pseudo = $_SESSION['pseudo'];

    //On récupère les données relatives au mot de passe
    $mdp_actuel = isset($_POST["mdp_actuel"]) ? $_POST["mdp_actuel"] : ""; 
	$mdp_nouveau = isset($_POST["mdp_nouveau"]) ? $_POST["mdp_nouveau"] : ""; 
    $mdp_confirmer = isset($_POST["mdp_confirmer"]) ? $_POST["mdp_confirmer"] : "";
	$error = "" ;

    //On vérifie qu'aucune ligne ne soit vide
    if($mdp_actuel == "") { $error .= "Veuillez saisir votre mot de passe actuel!<br />";}
	if($mdp_nouveau == "") { $error .= "Veuillez saisir un nouveau mot de passe!<br />";}
	if($mdp_confirmer == "") { $error .= "Veuillez confirmer le nouveau mot de passe!<br />";}
    if($mdp_nouveau != $mdp_confirmer) { $error .= "Les nouveaux mots de passe de concordent pas!<br />";}
    
    //Si la variable error est toujours égale à sa valeur d'initialisation ("") alors il n'y a aucun champ vide
    if ($error != "") { 
        die ("Erreur: $error<br/>"); //On affiche l'erreur en question
    }

    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

    //Récupération de l'id de l'utilisateur connecté
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }

    //Vérification du mot de passe actuel
    $SQL = "SELECT mdp FROM utilisateur WHERE id_user='$id_user'";
    $result = $db_handle->query($SQL);

    //Récupération des données
    while ($db_field = $result->fetch_assoc()) { 
        if($db_field["mdp"] != $mdp_actuel){
            die ("Le mot de passe saisi ne correspond pas à votre mot de passe actuel!");
        }
    }

    //Libération des résultats
    $result->free();

    //Changer le mot de passe
    $SQL2 = "UPDATE utilisateur SET mdp='$mdp_nouveau' WHERE pseudo='$pseudo'";
    $db_handle->query($SQL2);

    //Retour à la gestion du profil
    header('Location: gestion_profil.php');

?>