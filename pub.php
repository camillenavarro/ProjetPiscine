<?php 

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

                $fileDestination = 'Photo/'.$fileNameNew;

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