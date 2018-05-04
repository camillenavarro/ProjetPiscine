<?php
	session_start();
	$mail = isset($_POST["mail"]) ? $_POST["mail"] : ""; 
	$pseudo = isset($_POST["pseudo"]) ? $_POST["pseudo"] : "";
	$mdp = isset($_POST["mdp"]) ? $_POST["mdp"] : "";
	$confirm = isset($_POST["confirm"]) ? $_POST["confirm"] : ""; 
	$fonction = $_POST["fonction"] ;
	$emploi = isset($_POST["emploi"]) ? $_POST["emploi"] : "";
	$entreprise = isset($_POST["entreprise"]) ? $_POST["entreprise"] : "";
	$degre = $_POST["degre"] ;
	$annee = $_POST["annee"] ;
	$nom = isset($_POST["nom"]) ? $_POST["nom"] : "";
	$prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : ""; 
	$naissance = isset($_POST["naissance"]) ? $_POST["naissance"] : "";
	$genre = isset($_POST["genre"]) ? $_POST["genre"] : "";
	$error = "" ;
	
	if($mail == "") { $error .= "Adresse email vide<br />";}
	if($pseudo == "") { $error .= "Nom d'utilisateur vide<br />";}
	if($mdp == "") { $error .= "Mot de passe vide<br />";}
	if($confirm == "") { $error .= "Veuillez confirmer votre mot de passe<br />";}
	if($mdp != $confirm) { $error .= "Mots de passe différents !<br />" ;}
	if($nom == "") { $error .= "Nom vide<br />";}
	if($prenom == "") { $error .= "Prénom vide<br />";}
	
	if($fonction == "Employe" && $emploi == "") { $error .= "Le champ emploi doit etre rempli pour un employe.<br />";}
	if($fonction != "Employe" && $emploi != "") { $error .= "Le champ emploi doit etre laisse vide pour un étudiant<br />" ;}
	if($fonction == "Apprenti" && $entreprise == "") { $error .= "Le champ entreprise doit etre rempli pour un apprenti.<br />";}
	if($fonction != "Apprenti" && $entreprise != "") { $error .= "Le champ entreprise doit etre laisse vide pour un étudiant non apprenti ou un employe<br />" ;}
	if($fonction != "Employe" && $degre == "Non renseigne") { $error .= "Le degre d'etude doit etre renseigne pour un etudiant.<br />";}
	if($fonction == "Employe" && $degre != "Non renseigne") { $error .= "Le degre d'etude doit etre laisse vide pour un employe.<br />";}
	if($fonction != "Employe" && $annee == "Non renseigne") { $error .= "Le nombre d'annees d'etude doit etre renseigne pour un etudiant.<br />";}
	if($fonction == "Employe" && $annee != "Non renseigne") { $error .= "Le nombre d'annees d'etude doit etre laisse vide pour un employe.<br />";}
	
	if($naissance != "") { $naissance = "'$naissance'" ;} 
		else { $naissance = "NULL" ;}
	if($genre != "") { $genre = "'$genre'" ;}
		else { $genre = "NULL" ;}
	
	//Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
		
		$SQL = "SELECT pseudo, mail FROM utilisateur" ;
		$result = $db_handle->query($SQL) ;
		
		
		while($liste = mysqli_fetch_array($result))
		{
			if($pseudo == $liste['pseudo']) { $error .= "Ce nom d'utilisateur est deja pris !<br />" ;}
			if($mail == $liste['mail']) { $error .= "Cet e-mail est deja pris !<br />" ;}
		}
			
		if($error == "")
		{
			//Insérer dans la table utilisateur
			
			//Requête d'insertion
			$SQL1 = "INSERT INTO utilisateur (pseudo,nom,prenom,mail,mdp,fonction,naissance,genre,droit) VALUES ('$pseudo', '$nom', '$prenom', '$mail', '$mdp', '$fonction', $naissance, $genre, 'auteur')";
			$db_handle->query($SQL1); 
			
			$SQL2 = "SELECT id_user FROM utilisateur WHERE pseudo = '$pseudo'" ;
			$result2 = $db_handle->query($SQL2);
			
			while($db_field2 = $result2->fetch_assoc())
			{
				$id = $db_field2['id_user'];
			}
			
			//Insérer dans la table profil
			
			//Récupération de l'id_user (nombre d'utilisateurs + 1)
			
			//Requête d'insertion
			$SQL3 = "INSERT INTO profil (id_user, acces) VALUES ('$id', 'public')";
			$db_handle->query($SQL3); 
			
			if($fonction == "Employe") 
			{
				$SQL4 = "INSERT INTO employe (id_user,poste) VALUES ('$id', '$emploi')" ;
				$db_handle->query($SQL4);
			}
			else
			{				
				$SQL5 = "INSERT INTO etudiant (id_user, etudes, annees) VALUES ('$id', '$degre', '$annee')" ;
				$db_handle->query($SQL5);
				
				if($fonction == "Apprenti")
				{
					$SQL6 = "INSERT INTO apprenti (id_user,entreprise) VALUES ('$id', '$entreprise')" ;
					$db_handle->query($SQL6);
				}
			}
			
			$SQL7 = "INSERT INTO connexion VALUES ('$id')";
			$db_handle->query($SQL7);
			
			$_SESSION['pseudo'] = $pseudo ;
			
			header("Location: accueil.php");			
			
			mysqli_close($db_handle);
		}
		else 
			echo "$error" ;
	
?>