<?php
    //Récupère les données du formulaire
    if (isset($_POST['etude'])) {
        $etude1 = nl2br(htmlspecialchars($_POST['etude']));
        $etude =  addslashes($etude1);
    }
    else{
        $etude = addslashes("Cet utilisateur n'a pas renseigné son parcours scolaire.");
    }

    if (isset($_POST['experience'])) {
        $experience1 = nl2br(htmlspecialchars($_POST['experience']));
        $experience =  addslashes($experience1);
        
    }
    else{
        $experience = addslashes("Cet utilisateur n'a pas renseigné son expérience professionnelle.");
    }

    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 

    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

    //Récupération de l'id de l'utilisateur connecté
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }

    //Requête SQL et mise à jour de la table profil
    $SQL = "UPDATE profil SET `experience`='$experience',`etude`='$etude' WHERE id_user='$id_user'";
    $db_handle->query($SQL);

    //Couper la connexion à la BDD
    $db_handle->close();

    //Redirection
    header('Location: gestion_profil.php');
    
?>