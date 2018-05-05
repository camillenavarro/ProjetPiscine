<!DOCTYPE html>
<html>
    <head>
    <link href="accueil.css" rel="stylesheet"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Publier une offre</title>
    </head>
    
    <body>
    <ul class="conteneur">
            
            <ul class="menu">
            <li> <a href="accueil.php"><button>Accueil</button></a></li>
               <li> <a href="gestion_profil.php"><button>Modifier mon profil</button></a></li>
                <li> <a href="profil.php"><button>Voir mon profil</button></a></li>
               <li> <a href="reseau.php"><button>Mon réseau</button></a></li>
               <li> <a href="notifications.php"><button>Mes notifications</button></a></li>
               <li> <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a></li> 
               <li> <a href="deconnexion.php"><button>Déconnexion</button></a></li>  
            </ul>
            
			<form action = "form_emploi_back.php" method = "post">
				<table>
                    <tr>
                        <td>Entreprise :</td>
                        <td><input type = "text" name = "entreprise"></td>
                    </tr>
					
					<tr>
                        <td>Type :</td>
                        <td><select name = "type">
							<option>Stage</option>
							<option>Interim</option>
							<option>Alternance</option>
							<option>CDD</option>
							<option>CDI</option>
						</select>
						</td>
                    </tr>
					
					<tr>
                        <td>Poste :</td>
                        <td><input type = "text" name = "poste"></td>
                    </tr>
					
					<tr>
                        <td>Lieu :</td>
                        <td><input type = "text" name = "lieu"></td>
                    </tr>
					
					<tr>
                        <td>Date de debut :</td>
                        <td><input type = "date" name = "debut"></td>
                    </tr>
					
					<tr>
                        <td>Date de fin :</td>
                        <td><input type = "date" name = "fin"></td>
                    </tr>
					
					<tr>
                        <td>Description :</td>
                        <td><TEXTAREA name="description" cols="40" rows="5"></TEXTAREA></td>
                    </tr>
				</table>
				<input type = "submit" value = "Publier">
			</form>
		</div>
	</body>
</html>
					