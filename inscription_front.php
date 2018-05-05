<?php
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

    //Récupération de l'id de l'utilisateur connecté
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);

    if($result7->num_rows != 1){
        $admin = false;
    }
    else {
        $admin = true;
    }
?>
<html>
	<head>
		<link href="inscription_front.css" rel="stylesheet">
		<title><?php if($admin == true) {echo "Ajouter un nouvel utilisateur";} else {echo "S'enregistrer";} ?></title>
		<meta charset = "uft-8" />
        <script type="text/javascript">
            function showfield(name){
                if(name=='Employe')document.getElementById('ifyesEmp').style.display = "table-row";
                else document.getElementById('ifyesEmp').style.display = "none";
                
                if(name=='Etudiant')document.getElementById('ifyesEtu').style.display = "table-row";
                else document.getElementById('ifyesEtu').style.display = "none";
                if(name=='Apprenti')
                {
                    document.getElementById('ifyesEtu').style.display = "table-row";
                    document.getElementById('ifyesApp').style.display = "table-row";
                }
                else 
                {
                    document.getElementById('ifyesApp').style.display = "none";
                }
            }
        </script>
	</head>
	<body>
        <div class="conteneur">
            <nav>
            <ul class="menu" <?php if($admin == true) {echo "style='display: block;'";} else {echo "style='display: none;'";} ?>>
               <li> <a href="accueil.php"><button>Accueil</button></a></li>
               <li> <a href="gestion_profil.php"><button>Modifier mon profil</button></a></li>
                <li> <a href="profil.php"><button>Voir mon profil</button></a></li>
               <li> <a href="reseau.php"><button>Mon réseau</button></a></li>
               <li> <a href="notifications.php"><button>Mes notifications</button></a></li>
               <li> <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a></li> 
               <li> <a href="deconnexion.php"><button>Déconnexion</button></a></li>  
        </ul>
            </nav>
            <h2><?php if($admin == true) {echo "Ajouter un nouvel utilisateur";} else {echo "S'enregistrer";} ?></h2>
            <p>Les champs marques d'un <i>*</i> sont obligatoires.</p>

            <form action="inscription_back.php" method="post">
                <table>
                    <tr>
                        <td>Adresse mail<i>*</i> :</td>
                        <td><input type = "text" name = "mail"><br><br>

            </td>
                    </tr>

                    <tr>
                        <td>Nom d'utilisateur<i>*</i> :</td>
                        <td><input type = "text" name = "pseudo"><br><br></td>
                    </tr>

                    <tr>
                        <td>Mot de passe<i>*</i> :</td>
                        <td><input type = "password" name = "mdp"><br><br></td>
                    </tr>

                    <tr>
                        <td>Confirmer le mot de passe<i>*</i> :</td>
                        <td><input type = "password" name = "confirm"><br><br></td>
                    </tr>

                    <tr>
                        <td>Occupation<i>*</i> :</td>
                        <td><select name = "fonction" onchange="showfield(this.options[this.selectedIndex].value)">
                                <option value="Etudiant">Etudiant</option>
                                <option value="Apprenti">Apprenti</option>
                                <option value="Employe">Employe</option>
                            </select><br><br></td>
                    </tr>

                    <tr id="ifyesEmp" style='display: none;' >
                        <td>Emploi<i>*</i> :</td>
                        <td><input type = "text" name = "emploi"><br><br></td>
                    </tr>

                    <tr id="ifyesEtu">
                        <td>Degre d'etude<i>*</i> :</td>
                        <td><select name = "degre">
                                <option>Non renseigne</option>
                                <option>license</option>
                                <option>master</option>
                            </select><br><br></td>
                        <td>Annee d'etude<i>*</i> :</td>
                        <td><select name = "annee">
                                <option>Non renseigne</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select><br><br></td>
                    </tr>
                    
                    <tr id="ifyesApp" style='display: none;'>
                        <td>Entreprise<i>*</i> :</td>
                        <td><input type = "text" name = "entreprise"><br><br></td>
                    </tr>

                    <tr>
                        <td>Nom<i>*</i> :</td>
                        <td><input type = "text" name = "nom"><br><br></td>
                    </tr>

                    <tr>
                        <td>Prenom<i>*</i> :</td>
                        <td><input type = "text" name = "prenom"><br><br></td>
                    </tr>

                    <tr>
                        <td>Date de naissance :</td>
                        <td><input type = "date" name = "naissance"><br><br></td>
                    </tr>

                    <tr>
                        <td>Genre :</td>
                        <td><input type="radio" name="genre" value="homme">Homme<br><br></td>
                        <td><input type="radio" name="genre" value="femme">Femme<br><br></td>
                        <td><input type="radio" name="genre" value="autre">Autre<br><br></td>
                    </tr>

                    <tr>
                        <td><button>Valider</button></td>
                    </tr>
                </table>
            </form>
            <r <?php if($admin == true) {echo "style='display: none;'";} else {echo "style='display: block;'";} ?>>Deja inscrit ? <a href = "login.html">Connectez-vous</a></r>
        </div>
	</body>
</html>