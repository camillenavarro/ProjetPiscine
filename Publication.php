<?php
//echo "Bonjour";
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
  //echo"essai";
    if (isset($_POST['Publi'])) {
        $recupText1 = nl2br(htmlspecialchars($_POST['Publi']));
        $recupText=  addslashes($recupText1);
    }
    //Connexion à la BDD
      $database = "piscine"; //Nom de la BDD
      $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
      $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
   
   //Eviter que des ? apparaissent à la place des accents
    $db_handle->query('SET NAMES utf8');
    header('Content-Type: text/html; charset=utf-8');

    //Récupération de l'id de l'utilisateur connecté
    $SQL7 = "SELECT id_user FROM connexion";
    $result7 = $db_handle->query($SQL7);
    while ($db_field7 = $result7->fetch_assoc()) { 
        $id_user = $db_field7["id_user"];
    }
    $type="texte";
    
    //Récupère les informations relatives à l'utilisateur connecté
    $SQL8 = "SELECT * FROM utilisateur WHERE id_user = '$id_user'";
    $result8 = $db_handle->query($SQL8);
    while ($db_field8 = $result7->fetch_assoc()) { 
        $nom = $db_field8["nom"];
        $prenom = $db_field8["prenom"];
    }
  
      //Requête SQL poster une publication texte
    $SQL = "INSERT INTO publication (`id_user`, `type`,`texte`, `statut`, `acces`) VALUES ('$id_user','$type', '$recupText', NULL, 'publique') ";
  $result = $db_handle->query($SQL);
    
    //On récupère l'id de la publication
    $SQL3 = "SELECT id_pub FROM publication WHERE id_user = '$id_user' AND texte = '$recupText'" ;
			$result3 = $db_handle->query($SQL3);
			
			while($db_field3 = $result3->fetch_assoc())
			{
				$id_pub = $db_field3['id_pub'];
			}

    //La publication crée une notification
    if($type == "texte"){
        //On créer une notification de type texte
        $SQL4 = "INSERT INTO `notif_pub`(`id_user`, `id_pub`, `texte`) VALUES ('$id_user','$id_pub','Nouvelle publication')";
        $db_handle->query($SQL4);
    }
    
        //Fermeture de la connexion à la BDD
        $db_handle->close();
    
    //Redirection
    header("Location: accueil.php");
}
if(isset($_POST['submit']))
{  
   
   
    $file = $_FILES['file'];
    print_r($file);
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];


    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg');
    if(in_array( $fileActualExt,$allowed))
    {
        if($fileError === 0){
            if($fileSize<500000)
            {
                $fileNameNew = uniqid('',true).".".$fileActualExt;

                $fileDestination = 'image/'.$fileNameNew;

                move_uploaded_file($fileTmpName,$fileDestination);
                //Connexion à la BDD
             $database = "piscine"; //Nom de la BDD
             $db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
             $db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 

             $dest = addslashes($fileDestination);
             $name = addslashes($fileNameNew);
                
                $SQL2= "INSERT INTO media(id_user,type,nom_fichier,titre,lieu,path) VALUES ('1','photo','$fileNameNew','Profil','Paris','$fileDestination')";
                $result = $db_handle->query($SQL2);
                   //Fermeture de la connexion à la BDD
                $db_handle->close();

              //  header("Location: Mur.php?uploadsucess");

            }else echo "Image trop lourde";

        }else{
            echo "Il ya eu une erreur lors du chargement de cotre image";
        }
    }else{
        echo "Tu ne peux pas charger ce type de fichier";
    }
}

 ?>

