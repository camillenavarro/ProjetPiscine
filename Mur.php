<html>
<body>


<h3>Envoi d'une image</h3>
 <form method="post" action="pub.php" enctype="multipart/form-data">
 <p>
 <input type="file" name="fic"/></br>
  <input type="submit"name="envoyer le fichier" value ="envoyer le fichier" />
</p>
  </form>
  <form method="post" action="Publication.php">
<table>
<p>
<tr>
 <td><label for="Pub">Publication :</label></td>
      <td>  <input type="text" name="Pub" id="Pub"/></td>
        <br />
</tr><tr> <td> <input type="submit" name="Soumettre" value="Soumettre"></td></tr>  
</p >
</table>
</form>




</body>
</html>