<?php
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); 

    //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

    //Récupération de l'id de l'utilisateur connecté
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }

    //Requête SQL et récupération des résultats
    $SQL = "SELECT experience, etude FROM profil WHERE id_user='$id_user'";
    $result = $db_handle->query($SQL);
    
    //Récupération des données
    while ($db_field = $result->fetch_assoc()) { 
        $etude = $db_field["etude"];
        $experience = $db_field["experience"];
    }

    //Fermer la connexion
    $db_handle->close();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Modifier mon parcours scolaire et mon expérience</title>
    </head>
    
    <body>
        <div class="conteneur">
            
            <div class="menu">
                <a href="accueil.php"><button>Accueil</button></a>
                <a href="gestion_profil.php"><button>Modifier mon profil</button></a>
                <a href="profil.php"><button>Voir mon profil</button></a>
                <a href="reseau.php"><button>Mon réseau</button></a>
                <a href="notifications.php"><button>Mes notifications</button></a>
                <a href="liste_emplois.php"><button>Mes offres d'emplois</button></a>
                <a href="deconnexion.php"><button>Déconnexion</button></a>
            </div>
            
            
            <h2>Modification</h2>        
            <!-- Bouton de submission -->
            <form action="modifier_etudes_experience_back.php" method="post">
                <h3>Parcours scolaire:</h3>
                <p><textarea name="etude" cols="40" rows="5"><?php echo $etude; ?></textarea></p>
            
                <h3>Expérience professionnelle:</h3>
                <p><textarea name="experience" cols="40" rows="5"><?php echo $experience; ?></textarea></p>
                
                <input type="submit" value="Sauvegarder les changements">
            </form>
        </div>
    
    </body>
</html>