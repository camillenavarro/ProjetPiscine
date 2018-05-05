<?php
    //Sauvegarde du pseudo
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <link href="accueil.css" rel="stylesheet"/>
        <meta charset = "uft-8" />
        <title>Modifier mon mot de passe</title>
    </head>
    
    <body>
    <ul class="menu">
            <li> <a href="accueil.php"><button>Accueil</button></a></li>
               <li> <a href="gestion_profil.php"><button>Modifier mon profil</button></a></li>
                <li> <a href="profil.php"><button>Voir mon profil</button></a></li>
               <li> <a href="reseau.php"><button>Mon réseau</button></a></li>
               <li> <a href="notifications.php"><button>Mes notifications</button></a></li>
               <li> <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a></li> 
               <li> <a href="deconnexion.php"><button>Déconnexion</button></a></li>  
            </ul>

            <h2>Modifier le mot de passe:</h2>

            <form action="modifier_mdp_back.php" method="post">
                <table>
                    <tr>
                        <td>Mot de passe actuel:</td>
                        <td><input type ="password" name="mdp_actuel"></td>
                    </tr>

                    <tr>
                        <td>Nouveau mot de passe:</td>
                        <td><input type ="password" name="mdp_nouveau"></td>
                    </tr>

                    <tr>
                        <td>Confirmer le mot de passe:</td>
                        <td><input type ="password" name="mdp_confirmer"></td>
                    </tr>

                    <tr>
                        <td><input type="submit" value="Valider"></td>
                    </tr>

                </table>
            </form>
        </div>
    </body>
</html>