<?php
    //On récupère le pseudo du compte
    session_start();
    $pseudo = $_SESSION['pseudo'];
    //On récupère les données relatives au mot de passe
    $modif_pseudo = isset($_POST["modif_pseudo"]) ? $_POST["modif_pseudo"] : ""; 
    $modif_nom = isset($_POST["modif_nom"]) ? $_POST["modif_nom"] : ""; 
	$modif_prenom = isset($_POST["modif_prenom"]) ? $_POST["modif_prenom"] : ""; 
    $modif_mail = isset($_POST["modif_mail"]) ? $_POST["modif_mail"] : ""; 
    $modif_genre = isset($_POST["modif_genre"]) ? $_POST["modif_genre"] : ""; 
    $modif_naissance = isset($_POST["modif_naissance"]) ? $_POST["modif_naissance"] : "";
    $modif_fonction = isset($_POST["modif_fonction"]) ? $_POST["modif_fonction"] : "";
    $modif_poste = isset($_POST["modif_poste"]) ? $_POST["modif_poste"] : "";
    $modif_degre = isset($_POST["modif_degre"]) ? $_POST["modif_degre"] : ""; 
    $modif_annees = isset($_POST["modif_annees"]) ? $_POST["modif_annees"] : ""; 
    $modif_entreprise = isset($_POST["modif_entreprise"]) ? $_POST["modif_entreprise"] : ""; 
	$error = "" ;
    //On vérifie qu'aucune ligne ne soit vide
    if($modif_pseudo == "") { $error .= "Veuillez saisir un pseudo!<br />";}
    if($modif_nom == "") { $error .= "Veuillez saisir un nom!<br />";}
	if($modif_prenom == "") { $error .= "Veuillez saisir un prénom!<br />";}
    if($modif_mail == "") { $error .= "Veuillez saisir un mail!<br />";}
    if($modif_fonction == "") { $error .= "Veuillez saisir une occupation!<br />";}
    //Si l'utilisateur est maintenant un employé
    if($modif_fonction == "Employe" and $modif_poste == "") { $error .= "Veuillez saisir un poste!<br />";}
    //Si l'utilisateur est maintenant un apprenti
    if($modif_fonction == "Apprenti" and $modif_entreprise == "") { $error .= "Veuillez saisir une entreprise!<br />";}
    //Si la variable error est toujours égale à sa valeur d'initialisation ("") alors il n'y a aucun champ vide
    if ($error != "") { 
        die ("$error<br/>"); //On affiche l'erreur en question
    }
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
    //Sélectionner l'id de l'utilisateur
    $SQL = "SELECT * from utilisateur where pseudo='$pseudo'";
    $result = $db_handle->query($SQL);
    //Récupérer l'id_user
    while ($db_field = $result->fetch_assoc()) { 
        $id_user = $db_field["id_user"];
        $fonction_old = $db_field["fonction"];
        $mail_old = $db_field["mail"];
        $pseudo_old = $db_field["pseudo"];
    }
    //On vérifie que la nouvelle adresse mail n'existe pas déjà dans la BDD
    if($mail_old != $modif_mail){ //Si l'utilisateur a décidé de changer son adresse mail
        //On recherche l'adresse mail parmis tous les utilisateurs
        $SQL11 = "SELECT id_user from utilisateur where mail='$modif_mail'";
        $result11 = $db_handle->query($SQL11);
        //On affiche un message d'erreur si c'est le cas
        if($result11->num_rows != 0){
            die ("Cette adresse mail existe déjà!");
        }
    }
    //On vérifie que le nouveau pseudo n'existe pas déjà dans la BDD
    if($pseudo_old != $modif_pseudo){ //Si l'utilisateur a décidé de changer son adresse mail
        //On recherche l'adresse mail parmis tous les utilisateurs
        $SQL12 = "SELECT id_user from utilisateur where pseudo='$modif_pseudo'";
        $result12 = $db_handle->query($SQL12);
        //On affiche un message d'erreur si c'est le cas
        if($result12->num_rows != 0){
            die ("Ce pseudo existe déjà!");
        }
        
        //Sinon, on modifie en conséquence
        else{
            $SQL13 = "UPDATE utilisateur SET utilisateur.pseudo='$modif_pseudo' WHERE utilisateur.id_user='$id_user'";
            $db_handle->query($SQL13);
        }
    }
    //Mettre à jour la table utilisateur
    $SQL2 = "UPDATE utilisateur SET nom='$modif_nom', prenom='$modif_prenom', mail='$modif_mail', genre='$modif_genre', naissance='$modif_naissance', fonction='$modif_fonction'  WHERE id_user='$id_user'";
    $db_handle->query($SQL2);
    //Cas n°1 : un etudiant reste un étudiant ou devient un apprenti
    if($fonction_old == "Etudiant" and ($modif_fonction == "Etudiant" or $modif_fonction == "Apprenti")){
        //Cas n°1-1: un étudiant reste un étudiant
        //Mettre à jour la table etudiant dans tous les cas
        $SQL3 = "UPDATE etudiant SET etudes='$modif_degre', annees='$modif_annees'  WHERE id_user='$id_user'";
        $db_handle->query($SQL3);
        
        //Cas n°1-2 : un etudiant devient un apprenti
        //Mettre à jour la table apprenti 
        if($modif_fonction == "Apprenti"){
            $SQL4 = "INSERT INTO apprenti (`id_user`, `entreprise`) VALUES ((SELECT id_user FROM utilisateur WHERE id_user = '$id_user'), '$modif_entreprise')";
            $db_handle->query($SQL4);
        }    
    }
    
    //Cas n°2 : un apprenti redevient un simple etudiant
    if($fonction_old == "Apprenti" and $modif_fonction == "Etudiant"){
        
        //Mettre à jour la table etudiant dans tous les cas
        $SQL5 = "UPDATE etudiant SET etudes='$modif_degre', annees='$modif_annees'  WHERE id_user='$id_user'";
        $db_handle->query($SQL5);
        
        //Mettre à jour la table apprenti en supprimant l'apprenti
        $SQL6 = "DELETE FROM apprenti WHERE id_user='$id_user'";
        $db_handle->query($SQL6);
    }
       
    //Cas n°3 : un etudiant/apprenti devient un employé
    if(($fonction_old == "Etudiant" or $fonction_old == "Apprenti") and $modif_fonction == "Employe"){
        
        //Ajouter le nouvel employé
        $SQL7 = "INSERT INTO employe (`id_user`, `poste`) VALUES ('$id_user', '$modif_poste')";
        $db_handle->query($SQL7);
        
        //Cas n°3-1 : un étudiant devient un employé        
        $SQL8 = "DELETE FROM etudiant WHERE id_user='$id_user'";
        $db_handle->query($SQL8);
        
        //Cas n°3-2 : un apprenti devient un employé
        //Supprimer l'apprenti de la table
        if($fonction_old == "Apprenti"){
            $SQL9 = "DELETE FROM apprenti WHERE id_user='$id_user'";
            $db_handle->query($SQL9);
        }
    }
       
    //Cas n°4 : un employé modifie ses informations
    if($fonction_old == "Employe" and $modif_fonction == "Employe"){
        //Modifier la table employé
        $SQL10 = "UPDATE employe SET poste='$modif_poste' WHERE id_user='$id_user'";
        $db_handle->query($SQL10);
    }
    //Retour à la gestion du profil
    header('Location: gestion_profil.php');
    //Fermer la connexion
    $db_handle->close();
?>