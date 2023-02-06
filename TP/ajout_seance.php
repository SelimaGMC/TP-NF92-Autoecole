<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">

  </head>
  <body>
    <h1> Ajout d'une séance </h1>
    <div class="main">
    <p> Veuillez entrer une date pour la séance, un effectif maximal et un thème.
    <?php
    include('connexion.php');

    echo <<<EOT
    <form action="ajouter_seance.php" method="POST">
        <table>
          <tr>
            <td><label for='nom_seance'>Date de la séance: </label></td>
            <td><input type='date' id='nom_seance' name='date_seance' min="$date_auj" required></td>
          </tr>
          <tr>
            <td><label for='effmax'>Effectif Maximal: </label></td>
            <td><input type='number' name='effmax' id='effmax' min="0" required></td>
          </tr>
          <tr>
            <td><label for='theme'> Thème: </label> </td>
            <td><select name='theme' id='theme'>
            <br>
    EOT ;
    $liste_themes = mysqli_query($connect,"SELECT * FROM themes where supprime=0 ");
    if (!$liste_themes){
      echo "La requête a échoué: ".mysqli_error($connect);
    }
    while ($row = mysqli_fetch_array($liste_themes)){  //foreach($liste_themes as $theme){  echo <option value =\"$theme[idtheme]\"> etc.. }
    echo <<< EOT
                     <option value={$row['idtheme']}>{$row['nom']}</option>
                     <br>
    EOT ;
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
    mysqli_close($connect);
     ?>
   </div>
  </body>
</html>
