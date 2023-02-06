<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h1> Désinscrire un élève d'une séance </h1>
    <div class="main">
    <?php
    include 'connexion.php';


      $date = date("Ymd");
      $result_query_seance = "SELECT * FROM seances INNER JOIN themes
        WHERE seances.idtheme=themes.idtheme and DateSeance >= $date";
                    //On ne sélectionne que les séances dans le futur
      $result_seance = mysqli_query ($connect, $result_query_seance);

      $result_query_eleve = "SELECT * FROM eleves";
                    //On sélectionne tous les eleves
      $result_eleve = mysqli_query ($connect, $result_query_eleve);

      if (!$result_seance) {
        echo 'Erreur : ' . mysqli_error($connect);
        exit; }

      if (!$result_eleve) {
        echo 'Erreur : ' . mysqli_error($connect);
        exit; }
        // On vérifie que les requête soient bien fonctionelles

      if ((mysqli_num_rows($result_seance) or mysqli_num_rows($result_eleve)) == 0) {
        echo "Erreur aucun élève ou aucune séance n'ont été trouvés";
        echo " <br> <a href='desinscription_seance.php' target='contenu'> Recommencer </a> ";
      }
      else {  //Formulaire de sélection pour la désinscription
        echo <<<EOT
        <p> Veuillez sélectionner l'élève à désinscrire et la séance: </p>
        <FORM METHOD='POST' ACTION='desinscrire_seance.php' >
        <table>
          <tr>
            <td> Elève: </td>
            <td> <select name ='eleve'>
        EOT;
        //Dropdown list de tous les élèves
        while ($response_eleve = mysqli_fetch_array($result_eleve)) {
          echo "<option value=".$response_eleve['ideleve'].">".$response_eleve['nom']." ".$response_eleve['prenom']." (".$response_eleve['dateNaiss'].")</option>";
        } // La date de naissance permet de différencier les homonymes
        echo"</select> </td>";

        echo"<tr> <td> Séance: </td>";
        echo"<td> <select name ='seance'>";
        //affichage des séances futures
        while ($response_seance = mysqli_fetch_array($result_seance)) {
          // Calcul des places restantes
          $selected_seance = $response_seance['idseance'];
          $effectif_query = "SELECT * FROM inscription WHERE idseance = $selected_seance";
          $effectif  = mysqli_query($connect, $effectif_query);
          $effectif_nombre = mysqli_num_rows($effectif);
          if (!$effectif) {
            echo 'Impossible d\'exécuter la requête : ' . mysqli_error($connect);
            exit; }


          if (!$effectif_nombre = '0'){ //vérif qu'il existe des élèves inscrit à la séance
            echo "<option value=".$response_seance['idseance'].">".$response_seance['nom']." (".$response_seance['DateSeance'].")</option><br>";

          }
        }

        echo"</select> </td> </tr>";
        echo "<tr> <td> <input type='reset' name='clear' value='Clear'> </td> ";
        echo "<td> <input type='submit' name='Send' value='Send'> </td> </tr>";
        echo"</table> </form>";
      }


      mysqli_close($connect);
     ?>
   </div>
  </body>
</html>
