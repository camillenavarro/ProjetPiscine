<?php
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

    //Récupère les informations relatives à l'utilisateur connecté
    $SQL8 = "SELECT * FROM utilisateur WHERE id_user = '$id_user'";
    $result8 = $db_handle->query($SQL8);
    while ($db_field8 = $result7->fetch_assoc()) { 
        $nom = $db_field8["nom"];
        $prenom = $db_field8["prenom"];
    }
    
    //Si l'utilisateur poste un texte
    if(isset($_POST['Soumettre']))
    {
        $type="texte";
        $texte = "Nouvelle publication";
        
        //On vérifie qu'il a écrit du texte dans la zone de texte
        if (isset($_POST['Publi'])) {
            $recupText1 = nl2br(htmlspecialchars($_POST['Publi'])); //Pour éviter les caractères spéciaux mal lus
            $recupText=  addslashes($recupText1); //Lire les ' et "
        }
        else $recupText = null;


        //Requête SQL poster une publication texte
        $SQL = "INSERT INTO publication (`id_user`, `type`,`texte`) VALUES ('$id_user','$type', '$recupText')";
        $result = $db_handle->query($SQL);

        //On récupère l'id de la publication
        $SQL3 = "SELECT id_pub FROM publication WHERE id_user = '$id_user' AND texte = '$recupText'" ;
        $result3 = $db_handle->query($SQL3);

        while($db_field3 = $result3->fetch_assoc())
        {
            $id_pub = $db_field3['id_pub'];
        }

        //La publication crée une notification : notif_pub
        $SQL4 = "INSERT INTO `notif_pub`(`id_user`, `id_pub`, `texte`) VALUES ('$id_user','$id_pub','$texte')";
        $db_handle->query($SQL4);

        //Fermeture de la connexion à la BDD
        $db_handle->close();

        //Redirection
        header("Location: accueil.php");
    }


    if(isset($_POST['submit']))
    {  
        $type="photo";
        $texte = "Photo";
        
        //Variables liées au fichier pour enregistrer une image
        $file = $_FILES['file'];
        print_r($file);
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        //Types de fichiers autorisées
        $allowed = array('jpg','jpeg', 'png');
        
        //Si le fichier est bon
        if(in_array( $fileActualExt,$allowed))
        {
            //On vérifie qu'il n'y aucune erreur
            if($fileError === 0){
                //Que la taille du fichier est correcte
                if($fileSize<1000000)
                {
                    //Nouveau nom de l'image 
                    $fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = 'image/'.$fileNameNew; //Destination de l'image
                    
                    //On copie l'image de l'utilisateur dans notre dossier
                    move_uploaded_file($fileTmpName,$fileDestination);

                    //Caractères spéciaux autorisés
                    $dest = addslashes($fileDestination);
                    $name = addslashes($fileNameNew);

                    //Requête pour insérer la nouvelle image dans la table media
                    $SQL2= "INSERT INTO media(id_user,type,nom_fichier,titre) VALUES ('$id_user','photo','$fileNameNew','Album')";
                    $db_handle->query($SQL2);
                    
                    //Requête pour récupérer l'id de la nouvelle photo
                    $SQL3 = "SELECT id_media FROM media WHERE id_user = '$id_user' AND nom_fichier = '$fileNameNew'";
                    $result3 = $db_handle->query($SQL3);

                    while($db_field3 = $result3->fetch_assoc())
                    {
                        $id_photo = $db_field3['id_media'];
                    }
                    
                     //On regarde si il y a un texte associé à l'image
                    if (isset($_POST['Publi'])) {
                        $recupText1 = nl2br(htmlspecialchars($_POST['Publi'])); //Pour éviter les caractères spéciaux mal lus
                        $recupText=  addslashes($recupText1); //Lire les ' et "
                    }
                    
                    //Requête pour insérer dans la table publication
                    if($recupText != null){
                        $SQL4 = "INSERT INTO publication (`id_user`,`id_media`, `type`,`texte`) VALUES ('$id_user','$id_photo','$type', '$recupText') ";
                        $result4 = $db_handle->query($SQL4);
                    }
                    else {
                        $SQL4 = "INSERT INTO publication (`id_user`,`id_media`, `type`) VALUES ('$id_user','$id_photo','$type') ";
                        $result4 = $db_handle->query($SQL4);
                    }
                    
                    //On récupère l'id de la publication
                    $SQL5 = "SELECT id_pub FROM publication WHERE id_user = '$id_user' AND id_media = '$id_photo'";
                    $result5 = $db_handle->query($SQL5);

                    while($db_field5 = $result5->fetch_assoc())
                    {
                        $id_pub = $db_field5['id_pub'];
                    }

                    //La publication crée une notification : notif_pub
                    $SQL4 = "INSERT INTO `notif_pub`(`id_user`, `id_pub`, `texte`) VALUES ('$id_user','$id_pub','$texte')";
                    $db_handle->query($SQL4);
                       
                    //Fermeture de la connexion à la BDD
                    $db_handle->close();

                    //Redirection
                    header("Location: accueil.php");

                }else echo "Image trop lourde !";

            }else{
                echo "Il ya eu une erreur lors du chargement de votre image !";
            }
        }else{
            echo "Tu ne peux pas charger ce type de fichier !";
        }
    }

?>

