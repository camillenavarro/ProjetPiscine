<?php
if(isset($_POST["envoyer le fichier"]))
{
if(isset($_FILES['fic'])AND $_FILES['fic']['error']==1)
{ // $taille = $_FILES['fic']['size'];
    echo "hlp";
    if($_FILES['fic']['size']<= 1000000)
    {
        $infosfichier = pathinfo($_FILES['fic']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($extension_upload, $extensions_autorisees))
        {
                // On peut valider le fichier et le stocker définitivement
                move_uploaded_file($_FILES['fic']['tmp_name'], 'uploads/' . basename($_FILES['fic']['name']));
                echo "L'envoi a bien été effectué !"; 
                echo"essai";
   /*  //Connexion à la BDD
     $database = "piscine"; //Nom de la BDD
     $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
     $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

  $nom = $_FILES['fic']['name'];
  $type = $_FILES['fic']['type'];

  $lieu = $_FILES['fic']['tmp_name'];
    


   $SQL2= "INSERT INTO media(id_user,type,nom_fichier,titre,lieu,date) VALUES ('1','poubelle','pas mangeable','','PAris',NULL)";
   echo "Je suis passé par là1";
   $result = $db_handle->query($SQL2);
    echo "Je suis passé par là";
   //Fermeture de la connexion à la BDD
   $db_handle->close();*/
        }
    }
        
    }
}
?>