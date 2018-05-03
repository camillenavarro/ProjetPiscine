<?php
    //Sauvegarde du pseudo
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "uft-8" />
        <title>Modifier mon mot de passe</title>
    </head>
    
    <body>
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
        
    </body>
</html>