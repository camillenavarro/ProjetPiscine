<?php
	session_start() ;
	$pseudo = $_SESSION['pseudo'] ;
	$type = $_POST["type"];
	
	$file = $_FILES['uploadFile'];
    print_r($file);
	$fileName = $_FILES['uploadFile']['name'] ;
	$fileTmpName = $_FILES['uploadFile']['tmp_name'];
    $fileSize = $_FILES['uploadFile']['size'];
    $fileError = $_FILES['uploadFile']['error'];
    $fileType = $_FILES['uploadFile']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg','jpeg');
	
    if(in_array( $fileActualExt,$allowed))
    {
        if($fileError === 0)
		{
            if($fileSize<500000)
            {
                $photo = uniqid('',true).".".$fileActualExt;
                $fileDestination = 'image/'.$photo;
                move_uploaded_file($fileTmpName,$fileDestination);
                //Connexion à la BDD
				$database = "piscine"; //Nom de la BDD
				$db_handle = new mysqli("localhost", "root", "") or die ("Connexion au serveur impossible!"); //Vérification de la connexion au serveur
				$db_found = $db_handle->select_db($database) or die ("Base de données introuvable!"); //Vérification que la BDD existe 
				$dest = addslashes($fileDestination);
				$name = addslashes($photo);
					
				$SQL = "SELECT id_user FROM utilisateur WHERE pseudo = '$pseudo' ";
				$result = $db_handle->query($SQL);
			
				while($db_field = $result->fetch_assoc())
				{
					$id_user = $db_field['id_user'];
				}
				$SQL = "SELECT id_user FROM utilisateur WHERE pseudo = '$pseudo' ";
				$result = $db_handle->query($SQL);
			
				while($db_field = $result->fetch_assoc())
				{
					$id_user = $db_field['id_user'];
				}
			
				$SQL2 = "SELECT * FROM profil WHERE id_user = '$id_user' ";
				$result2 = $db_handle->query($SQL2) ;
			
				while($db_field2 = $result2->fetch_assoc())
				{
					$id_profil = $db_field2['id_photo'];
					$id_fond = $db_field2['id_fond'];
				}
				
				if($type == "Modifier mon fond")
				{
					if($id_fond != NULL)
					{
						$SQL3 = "UPDATE media SET nom_fichier = '$photo' WHERE id_media = '$id_fond'" ;
						$db_handle->query($SQL3);
					}
					else
					{
						$SQL5 = "INSERT INTO media (id_user,type,nom_fichier,titre) VALUES ('$id_user', 'photo', '$photo', 'Fond')";
						$db_handle->query($SQL5);

						$SQL4 = "SELECT id_media FROM media WHERE id_user = '$id_user' AND titre = 'Fond'" ;
						$result4 = $db_handle->query($SQL4);
						
						while($db_field4 = $result4->fetch_assoc())
						{
							$id_media = $db_field4['id_media'];
						}						

						$SQL6 = "UPDATE profil SET id_fond = '$id_media' WHERE id_user = '$id_user' ";
						$db_handle->query($SQL6) ;			
					}
				}
				else
				{
					if($id_profil != NULL)
					{
						$SQL3 = "UPDATE media SET nom_fichier = '$photo' WHERE id_media = '$id_profil'" ;
						$db_handle->query($SQL3);
					}
					else
					{
						
						$SQL5 = "INSERT INTO media (id_user,type,nom_fichier,titre) VALUES ('$id_user', 'photo', '$photo', 'Profil')";
						$db_handle->query($SQL5);	
						
						$SQL4 = "SELECT id_media FROM media WHERE id_user = '$id_user' AND titre = 'Profil'" ;
						$result4 = $db_handle->query($SQL4);
						
						while($db_field4 = $result4->fetch_assoc())
						{
							$id_media = $db_field4['id_media'];
						}

						$SQL6 = "UPDATE profil SET id_photo = '$id_media' WHERE id_user = '$id_user' ";
						$db_handle->query($SQL6) ;			
					}
					
				}
				header("Location: gestion_profil.php");
			}
		}
	}
?>