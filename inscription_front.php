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
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
            <div class="menu" <?php if($admin == true) {echo "style='display: block;'";} else {echo "style='display: none;'";} ?>>
                <a href="accueil.php"><button>Accueil</button></a>
                <a href="gestion_profil.php"><button>Modifier mon profil</button></a>
                <a href="profil.php"><button>Voir mon profil</button></a>
                <a href="reseau.php"><button>Mon réseau</button></a>
                <a href=""><button>Mes notifications</button></a>
                <a href=""><button>Mes offres d'emplois</button></a>
                <a href="deconnexion.php"><button>Déconnexion</button></a>
            </div>
            <h2><?php if($admin == true) {echo "Ajouter un nouvel utilisateur";} else {echo "S'enregistrer";} ?></h2>
            <p>Les champs marques d'un * sont obligatoires.</p>

            <form action="inscription_back.php" method="post">
                <table>
                    <tr>
                        <td>Adresse mail * :</td>
                        <td><input type = "text" name = "mail"></td>
                    </tr>

                    <tr>
                        <td>Nom d'utilisateur * :</td>
                        <td><input type = "text" name = "pseudo"></td>
                    </tr>

                    <tr>
                        <td>Mot de passe * :</td>
                        <td><input type = "password" name = "mdp"></td>
                    </tr>

                    <tr>
                        <td>Confirmer le mot de passe * :</td>
                        <td><input type = "password" name = "confirm"></td>
                    </tr>

                    <tr>
                        <td>Occupation * :</td>
                        <td><select name = "fonction" onchange="showfield(this.options[this.selectedIndex].value)">
                                <option value="Etudiant">Etudiant</option>
                                <option value="Apprenti">Apprenti</option>
                                <option value="Employe">Employe</option>
                            </select></td>
                    </tr>

                    <tr id="ifyesEmp" style='display: none;' >
                        <td>Emploi * (si employe) :</td>
                        <td><input type = "text" name = "emploi"></td>
                    </tr>

                    <tr id="ifyesEtu">
                        <td>Degre d'etude * (si etudiant) :</td>
                        <td><select name = "degre">
                                <option>Non renseigne</option>
                                <option>license</option>
                                <option>master</option>
                            </select></td>
                        <td>Annee d'etude * (si etudiant) :</td>
                        <td><select name = "annee">
                                <option>Non renseigne</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select></td>
                    </tr>
                    
                    <tr id="ifyesApp" style='display: none;'>
                        <td>Entreprise * (si apprenti) :</td>
                        <td><input type = "text" name = "entreprise"></td>
                    </tr>

                    <tr>
                        <td>Nom * :</td>
                        <td><input type = "text" name = "nom"></td>
                    </tr>

                    <tr>
                        <td>Prenom * :</td>
                        <td><input type = "text" name = "prenom"></td>
                    </tr>

                    <tr>
                        <td>Date de naissance :</td>
                        <td><input type = "date" name = "naissance"></td>
                    </tr>

                    <tr>
                        <td>Genre :</td>
                        <td><input type="radio" name="genre" value="homme">Homme</td>
                        <td><input type="radio" name="genre" value="femme">Femme</td>
                        <td><input type="radio" name="genre" value="autre">Autre</td>
                    </tr>

                    <tr>
                        <td><button>Valider</button></td>
                    </tr>
                </table>
            </form>
            <p <?php if($admin == true) {echo "style='display: none;'";} else {echo "style='display: block;'";} ?>>Deja inscrit ? <a href = "login.html">Connectez-vous</a></p>
        </div>
	</body>
</html>