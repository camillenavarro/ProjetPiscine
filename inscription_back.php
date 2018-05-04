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
	
	$database = "piscine"; //Nom de la BDD
	$db_handle = mysqli_connect("localhost", "root", ""); //Connexion au serveur
	$db_found = mysqli_select_db($db_handle, $database); //Renvoie un booléen: true (BDD trouvée), false sinon
		
	if($db_found)
	{
		$SQL = "SELECT pseudo, mail FROM utilisateur" ;
		$result = mysqli_query($db_handle, $SQL) ;
		
		
		while($liste = mysqli_fetch_array($result))
		{
			if($pseudo == $liste['pseudo']) { $error .= "Ce nom d'utilisateur est deja pris !<br />" ;}
			if($mail == $liste['mail']) { $error .= "Cet e-mail est deja pris !<br />" ;}
		}
			
		if($error == "")
		{
			//Insérer dans la table utilisateur
			
			//Récupération de l'id_user (nombre d'utilisateurs + 1)
			$SQLuser = "SELECT COUNT(id_user) FROM utilisateur" ;
			$result_user = mysqli_query ($db_handle, $SQLuser) ;
			$count_user = mysqli_fetch_array($result_user);
			$id = $count_user['COUNT(id_user)'] + 1;
			//Requête d'insertion
			$SQL1 = "INSERT INTO utilisateur VALUES ('$id', '$pseudo', '$nom', '$prenom', '$mail', '$mdp', '$fonction', $naissance, $genre, 'auteur')";
			mysqli_query($db_handle, $SQL1); 
			
			//Insérer dans la table profil
			
			//Récupération de l'id_user (nombre d'utilisateurs + 1)
			$SQLprofil = "SELECT COUNT(id_profil) FROM profil" ;
			$result_profil = mysqli_query ($db_handle, $SQLprofil) ;
			$count_profil = mysqli_fetch_array($result_profil);
			$id_profil = $count_profil['COUNT(id_profil)'] + 1;
			//Requête d'insertion
			$SQL2 = "INSERT INTO profil VALUES ('$id_profil', '$id', NULL, NULL, NULL, NULL, NULL, 'public')";
			mysqli_query($db_handle, $SQL2); 
			
			if($fonction == "Employe") 
			{
				$SQLcount_employe = "SELECT COUNT(id_employe) FROM employe" ;
				$result_emp = mysqli_query ($db_handle, $SQLcount_employe) ;
				$count_emp = mysqli_fetch_array($result_emp);
				$id_emp = $count_emp['COUNT(id_employe)'] + 1;
				$SQLemploye = "INSERT INTO employe VALUES ('$id_emp', '$id', '$emploi')" ;
				mysqli_query($db_handle, $SQLemploye);
			}
			else
			{				
				$SQLcount_etudiant = "SELECT COUNT(id_etu) FROM etudiant" ;
				$result_etu = mysqli_query ($db_handle, $SQLcount_etudiant) ;
				$count_etu = mysqli_fetch_array($result_etu);
				$id_etu = $count_etu['COUNT(id_etu)'] + 1;
				$SQLetudiant = "INSERT INTO etudiant VALUES ('$id_etu', '$id', '$degre', '$annee')" ;
				mysqli_query($db_handle, $SQLetudiant);
				
				if($fonction == "Apprenti")
				{
					$SQLcount_apprenti = "SELECT COUNT(id_apprenti) FROM apprenti" ;
					$result_app = mysqli_query ($db_handle, $SQLcount_apprenti) ;
					$count_app = mysqli_fetch_array($result_app);
					$id_app = $count_app['COUNT(id_apprenti)'] + 1;
					$SQLapprenti = "INSERT INTO apprenti VALUES ('$id_app','$id', '$entreprise')" ;
					mysqli_query($db_handle, $SQLapprenti);
				}
			}
			
			$_SESSION['pseudo'] = $pseudo ;
			
			header("Location: accueil.php");				
			
			mysqli_close($db_handle);
		}
		else 
			echo "$error" ;
	}
	else
		echo "Base de données introuvable!";
	
?>