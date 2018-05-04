<?php
    session_start();
    $pseudo = $_SESSION['pseudo'];

    //On détermine si la personne voulant s'inscrire est un nouvel utilisateur ou un administrateur voulant inscrire un nouveau utilisateur
    if($pseudo == ""){
        echo "Nouvel utilisateur!";
    }
    else{
        echo "Administrateur!";
    }
?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<title>Projet Piscine</title>
		<meta charset = "uft-8" />
	</head>
	<body>
	<form action="inscription_back.php" method="post">
		<h2>S'enregistrer</h2>
		<br>Les champs marques d'un * sont obligatoires.<br>
		<br>Adresse email * :
		<br><input type = "text" name = "mail">
		<br>Nom d'utilisateur * :
		<br><input type = "text" name = "pseudo">
		<br>Mot de passe * :
		<br><input type = "password" name = "mdp">
		<br>Confirmer le mot de passe * :
		<br><input type = "password" name = "confirm">
		<br>Fonction * :
		<br><select name = "fonction">
			<option>Etudiant</option>
			<option>Apprenti</option>
			<option>Employe</option>
		</select>
		<br>Emploi * (si employe) :
		<br><input type = "text" name = "emploi">
		<br>Entreprise * (si apprenti) :
		<br><input type = "text" name = "entreprise">
		<br>Degre d'etude * (si etudiant) :
		<br><select name = "degre">
			<option>Non renseigne</option>
			<option>license</option>
			<option>master</option>
		</select>
		<br>Annee d'etude * (si etudiant) :
		<br><select name = "annee">
			<option>Non renseigne</option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
		<br>Nom * :
		<br><input type = "text" name = "nom">
		<br>Prenom * :
		<br><input type = "text" name = "prenom">
		<br>Date de naissance :
		<br><input type = "date" name = "naissance">
		<br>Genre :
		<br><input type="radio" name="genre" value="homme">Homme
		<br><input type="radio" name="genre" value="femme">Femme
		<br><input type="radio" name="genre" value="autre">Autre
		<br><button>Valider</button>
	</form>
		<br>
		Deja inscrit ? <a href = "login.html">Connectez-vous</a>
	</body>
</html>