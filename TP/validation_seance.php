<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h1> Notation d'un élève </h1>
    <div class="main">
    <p> Veuillez sélectionner une séance à noter: </p>
    <?php
    include "connexion.php";
    echo <<<EOT
    <form action="valider_seance.php" method="POST">
        <table>
          <tr>
            <td><label for='seance'> Séance: </label> </td>
            <td><select name='seance' id='seance'>

    EOT ;
    $date = date("Ymd");
    $query = "SELECT * FROM seances INNER JOIN themes WHERE seances.idtheme=themes.idtheme and DateSeance <= $date";
    $tab = mysqli_query($connect, $query);
    #echo $query;

    if (!$tab){
      echo "La requête a échoué: ".mysqli_error($connect);
    }
    while ($row = mysqli_fetch_array($tab)) {

      echo "<option value=".$row['idseance'].">
      ".$row['nom']." (".$row['DateSeance'].")
      </option>";
    }

    echo <<< EOT
                </select></td>

          </tr>
          <tr>
            <td><input type='reset' value='Annuler'></td>
            <td><input type='submit' value='Valider'></td>
          </tr>
        </table>
      </form>

    EOT;
        #dropdown button avec les séances dans le passé, renvoie à valider_seance l'id séance
    mysqli_close($connect)

     ?>
   </div>
  </body>
</html>
