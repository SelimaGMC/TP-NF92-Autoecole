<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h2> Récapitulatif </h2>
    <?php
    include 'connexion.php';
    $id_seance= $_POST["seance"];
    // echo $id_seance;
      /* echo <<< EOT
      <tr>
        <td><label for='seance'> Séance: </label> </td>
        <td><input name="note">

        EOT; */
    $result_query_seance = "SELECT * FROM inscription INNER JOIN eleves
      ON inscription.idseance=$id_seance and inscription.ideleve=eleves.ideleve";
      // echo $result_query_seance
            //On sélectionne les élèves inscrits à cette séance
    $result_seance = mysqli_query ($connect, $result_query_seance);

    if (!$result_seance) { //On teste le résultat de la requête
        echo 'Impossible d\'exécuter la requête : ' . mysqli_error($connect);
   }

    if (empty($id_seance)) {
        echo "Erreur, aucune séance n'est séléctionnée";
        echo "<br> <a href='validation_seance.php' target='contenu'> Recommencer </a> ";
  }
            elseif (mysqli_num_rows($result_seance) == 0) { //Si aucun élève n'est inscrit, on l'affiche et on permet à l'utilisateur de réessayer
              echo "<div class='erreur'>";
              echo "<p>Erreur, aucun élève n'est inscrit. </p>";
              echo "<br> <a href='validation_seance.php' target='contenu'> Recommencer </a> ";
              echo "</div>";
  }
            else { //Si tout va bien, on génère la page pour noter les élèves
              echo <<< EOT
              <h2>Notation séance</h2>
              <div class="main">
              <p> Veuillez entrer les notes des élèves suivants: </p>
              <FORM METHOD='POST' ACTION='noter_eleves.php'>
              <table border = 1>
                <tr>
                  <td> Elève </td>
                  <td> Note </td>
                </tr>
              EOT;
              while ($response_seance = mysqli_fetch_array($result_seance)) { //affichage d'une interface de notation pour chaque élève

                $note = $response_seance['note'];
                $ideleve = $response_seance['ideleve'];

                echo "<tr> <td>".$response_seance['nom']." ".$response_seance['prenom']."</td>";
                echo "<input type='hidden' name='seance' value='".$id_seance."'>";
                if($note == -1){    //Pas de note enregistrée
                    //echo " Note:";
                    echo "<td><input type='number' min='0' max='40' name='".$response_seance['ideleve']."'></td> </tr>";
                    //echo "<br>";
                  }
                  else{             //note déja enregistrée
                    echo "<td><input type='number' min='0' max='40'
                    name='".$response_seance['ideleve']."'
                    value='".$response_seance['note']."'></td> </tr>";

                  }
              }

              echo "<tr> <td> <input type='reset' name='clear' value='Annuler'>  </td>";
              echo " <td> <input type='submit' name='Send' value='Valider'> </td> </tr>";
              echo" </table> </form> </div>";
            }




            mysqli_close($connect);

     ?>
   </form>
  </body>
</html>
