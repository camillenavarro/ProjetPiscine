<?php
echo "Bonjour";
if(isset($_POST['Afficher']))
{
  echo "Bonjour";
 //Connexion à la BDD
 $database = "piscine"; //Nom de la BDD
 $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
 $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

 $SQL2 ="SELECT * FROM publication";
 $result = $db_handle->query($SQL2);
 //Fermeture de la connexion à la BDD
 $db_handle->close();

} 
if(isset($_POST['Soumettre']))
{
  echo"essai";
 $recupText =  addslashes($_POST['Pub'] ) ;
 //Connexion à la BDD
      $database = "piscine"; //Nom de la BDD
      $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
      $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
   
   
  
      //Requête SQL poster une publication texte
    $SQL = "INSERT INTO publication (`id_user`, `id_media`, `type`,`texte`, `statut`, `acces`) VALUES ('1', NULL, '', '$recupText', NULL, 'publique') ";
  $result = $db_handle->query($SQL);


        //Fermeture de la connexion à la BDD
        $db_handle->close();
}


 ?>

