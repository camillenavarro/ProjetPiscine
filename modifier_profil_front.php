<?php
    //Sauvegarde du pseudo
    session_start();
    $pseudo = $_SESSION['pseudo'];

    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

    //Requête SQL et récupération des résultats
    $SQL = "SELECT * FROM utilisateur WHERE pseudo='$pseudo'";
    $result = $db_handle->query($SQL);

    //Variables
    $etudiant = null;
    $apprenti = null;

    //Récupération des données
    while ($db_field = $result->fetch_assoc()) { 
        $id_user = $db_field["id_user"];
        $nom = $db_field["nom"];
        $prenom = $db_field["prenom"];
        $mail = $db_field["mail"];
        $genre = $db_field["genre"];
        $naissance = $db_field["naissance"];
        $fonction = $db_field["fonction"];
        
        //Deux types de fonctions: étudiant ou employé
        if($fonction == "Etudiant"){
            $etudiant = true;
        }
        else if($fonction == "Apprenti") {
            $etudiant = true; //C'est un employé
            $apprenti = true;
        }
        else{
            $etudiant = false;
        }
        
        //Date de naissance optionnelle
        if($db_field["naissance"] == null){
            $naissance = "non précisée.";
        }
        else{
            $naissance = $db_field["naissance"];
        }
        
        $droit = $db_field["droit"];
    }

    //Si la personne est un étudiant
    if($etudiant == true){
        //Requête SQL
        $SQL2 = "SELECT * FROM etudiant WHERE id_user='$id_user'";
        $result2 = $db_handle->query($SQL2);
        
        //Récupération des résultats
        while ($db_field2 = $result2->fetch_assoc()) { 
            $etudes = $db_field2["etudes"];
            $annees = $db_field2["annees"];
        }
        
        //Libérations des résultats
        $result2->free();
        
        if($apprenti == true){
            //Requête SQL
            $SQL3 = "SELECT * FROM apprenti WHERE id_user='$id_user'";
            $result3 = $db_handle->query($SQL3);
        
            //Récupération des résultats
            while ($db_field3 = $result3->fetch_assoc()) { 
                $entreprise = $db_field3["entreprise"];
            }
        
            //Libérations des résultats
            $result3->free();
        }
    }

    //Sinon c'est un employé
    else{
        //Requête SQL
        $SQL3 = "SELECT * FROM employe WHERE id_user='$id_user'";
        $result3 = $db_handle->query($SQL3);
        
        //Récupération des résultats
        while ($db_field3 = $result3->fetch_assoc()) { 
            $poste = $db_field3["poste"];
        }
        
        //Libérations des résultats
        $result3->free();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "uft-8" />
        <title>Modifier mon profil</title>
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
        <h2>Modifier mes informations:</h2>
        
        <form action="modifier_profil_back.php" method="post">
            <table>
                <tr>
                    <td>Pseudo:</td>
                    <td><input type ="text" name="modif_pseudo" value="<?php echo $pseudo; ?>"></td>
                </tr>
                
                <tr>
                    <td>Nom:</td>
                    <td><input type ="text" name="modif_nom" value="<?php echo $nom; ?>"></td>
                </tr>
                
                <tr>
                    <td>Prénom:</td>
                    <td><input type ="text" name="modif_prenom" value="<?php echo $prenom; ?>"></td>
                </tr>
                
                <tr>
                    <td>E-mail:</td>
                    <td><input type ="text" name="modif_mail" value="<?php echo $mail; ?>"></td>
                </tr>
                
                <tr>
                    <td>Genre:</td>
                    <td><input type="radio" name="modif_genre" value="homme" <?php if($genre == "homme") { echo 'checked="checked"'; } ?>>homme</td>
                    <td><input type="radio" name="modif_genre" value="femme"<?php if($genre == "femme") { echo 'checked="checked"'; } ?>>femme</td>
                    <td><input type="radio" name="modif_genre" value="autre"<?php if($genre == "autre") { echo 'checked="checked"'; } ?>>autre</td>
                </tr>
                
                <tr>
                    <td>Date de naissance:</td>
                    <td><input type ="date" name="modif_naissance" value="<?php echo $naissance; ?>"></td>
                </tr>
                
                <tr>
                    <td>Occupation:</td>
                    <td><select name = "modif_fonction" onchange="showfield(this.options[this.selectedIndex].value)">
                        <option value="Employe"<?php if($fonction == "Employe") { echo "selected"; } ?>>Employe</option>
			             <option value="Etudiant"
                                 <?php if($fonction == "Etudiant") { echo "selected"; } 
                                        if($fonction == "Employe") { echo "style='display: none;'"; }
                                 ?>
                                 >Etudiant</option>
			             <option value="Apprenti"
                                 <?php if($fonction == "Apprenti") { echo "selected"; } 
                                        if($fonction == "Employe") { echo "style='display: none;'"; }
                                 ?>
                                 >Apprenti</option>
                        </select></td>
                </tr>
                
                <tr id="ifyesEmp" 
                    <?php if($fonction == "Employe") { echo "style='display: table-row;'"; } 
                          else { echo "style='display: none;'"; }?>> 
                    <td>Poste:</td>
                    <td><input type = "text" name = "modif_poste" value="<?php if($etudiant != true) {echo $poste;} else {echo "";} ?>"></td>
                </tr>
                
                <tr id="ifyesEtu" 
                    <?php if($fonction == "Etudiant" or $fonction == "Apprenti") { echo "style='display: table-row;'"; } 
                          else { echo "style='display: none;'"; }?>> 
                    <td>Degre d'etude: </td>
                    <td><select name = "modif_degre">
                        <option <?php if($etudiant == true and $etudes == "license") { echo "selected"; } ?>>license</option>
                        <option <?php if($etudiant == true and $etudes == "master") { echo "selected"; } ?>>master</option>
                        </select>
                    </td>
                    <td>Années d'études: </td>
                    <td><select name = "modif_annees">
                        <option <?php if($etudiant == true and $annees == 1) { echo "selected"; } ?>>1</option>
                        <option <?php if($etudiant == true and $annees == 2) { echo "selected"; } ?>>2</option>
                        <option <?php if($etudiant == true and $annees == 3) { echo "selected"; } ?>>3</option>
                        <option <?php if($etudiant == true and $annees == 4) { echo "selected"; } ?>>4</option>
                        <option <?php if($etudiant == true and $annees == 5) { echo "selected"; } ?>>5</option>
                        </select>
                    </td>
                </tr>
                
                <tr id="ifyesApp" 
                    <?php if($fonction == "Apprenti") { echo "style='display: table-row;'"; } 
                          else { echo "style='display: none;'"; }?>> 
                    <td>Entreprise:</td>
                    <td><input type = "text" name = "modif_entreprise" value="<?php if($apprenti != null) {echo $entreprise;} else {echo "";} ?>"></td>
                </tr>
                            
                <tr>
                    <td><input type="submit" value="Valider" value="<?php echo $pseudo; ?>"></td>
                </tr>
            
            </table>
        </form>
        
    </body>
</html>


