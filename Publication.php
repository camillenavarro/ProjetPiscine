<?php


if(isset($_POST['Soumettre']))
{
  
    $recupText = $_POST['Pub'];
 //Connexion à la BDD
      $database = "piscine"; //Nom de la BDD
      $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
      $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
    //Requête SQL poster une publication texte
    $SQL = "INSERT INTO publication (`id_pub`, `id_user`, `id_media`, `type`,`texte`, `statut`, `acces`) VALUES (NULL, '1', NULL, '', '$recupText', NULL, 'publique') ";
    $result = $db_handle->query($SQL);
}
/*if(isset($_POST['Envoyer']))
{
  //vérifie que le fichier à été téléchargé 
  if(!is_uploaded_file($_FILES['image']['tmp_name']))
  {
 echo 'Un problème est survenu durant l opération. Veuillez réessayer !';
  }
} else {
  //liste des extensions possibles   
  //$extensions = array('/png', '/gif', '/jpg', '/jpeg');

  //récupère la chaîne à partir du dernier / pour connaître l'extension
 // $extension = strrchr($_FILES['image']['type'], '/');

  //vérifie si l'extension est dans notre tableau           
 /* if(!in_array($extension, $extensions))
          {
      echo 'Vous devez uploader un fichier de type png, gif, jpg, jpeg.';
          }
  else*/{        

      //on définit la taille maximale
   /*   define('MAXSIZE', 500000);       
      if($_FILES['image']['size'] > MAXSIZE)
                  {
         echo 'Votre image est supérieure à la taille maximale de '.MAXSIZE.' octets';
                  }
      else {
    //Connexion à la BDD
    $database = "piscine"; //Nom de la BDD
    $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
    $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

   // $taille = getimagesize($image);
   // $type = $_FILES['image']['type'];
          //Lecture du fichier
          $image = file_get_contents($_FILES['image']['tmp_name']);
          $SQL = "INSERT INTO image(img_nom, img_desc,img_blob) VALUES('hello', 'test',$image)";

      if( $result = $db_handle->query($SQL))
        {  echo 'L\'insertion s est bien déroulée !';}
        else{echo 'L\'insertion s est mal déroulée !';}
       }
  }*/
}


?>


