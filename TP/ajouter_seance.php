<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h2> Récapitulatif: </h2>
    <?php
      include 'connexion.php';

      $date_seance = $_POST["date_seance"];
      if (empty($date_seance)) {
        $msgError ="Veuillez insérer la date de la séance";
        echo $msgError;
        echo "<br> <a href='ajout_seance.php' target='contenu'> Recommencer </a> ";
      };
      $effmax_seance = $_POST["effmax"];
      if (empty($effmax_seance)) {
        $msgError ="Veuillez saisir l'effectif maximal de la séance";
        echo $msgError;
        echo "<br> <a href='ajout_seance.php' target='contenu'> Recommencer </a> ";
      };
      $theme_seance = $_POST["theme"];
      if (empty($theme_seance)) {
        $msgError ="Veuillez sélectionner le thème associé à la séance";
        echo $msgError;
        echo "<br> <a href='ajout_seance.php' target='contenu'> Recommencer </a> ";
      };


        $date_seance = mysqli_real_escape_string($connect,$date_seance);
        $effmax = mysqli_real_escape_string($connect,$effmax_seance);
        $theme = mysqli_real_escape_string($connect,$theme_seance);

        $query = " SELECT * FROM seances WHERE  idtheme=$theme_seance AND DateSeance = $date_seance ";
        $liste_seances =mysqli_query($connect, $query);
        if (!$liste_seances){
          echo "Erreur: ". mysqli_error($connect);
        }
        if (mysqli_num_rows($liste_seances) !=0) {
          // Si la longueur de la liste des séances sur le même thème le même jour est non nulle,...
          echo "Vous ne pouvez pas avoir deux séances sur le même thème, le même jour.";
          echo " <br> <a href='ajout_seance.php' target='contenu'> Recommencer </a> ";
        }
        if ($date_seance < $date_auj){
          echo "erreur: La séance ne peut pas avoir lieu dans le passé";
          echo " <br> <a href='ajout_seance.php' target='contenu'> Recommencer </a> ";
        }
        else{
          $query = 'insert into seances values ( NULL,"'.$date_seance.'", "'.$effmax.'", "'.$theme.'")';
            // echo "<br>$query<br>";
        	  $result = mysqli_query($connect, $query);
            if (!$result) echo mysqli_error($connect);
            else {
              echo "<div class='main> <p> Requête effectuée </p>";
              echo '<br> <a href="accueil.html" target="contenu" > Retour vers l\'accueil </a> </div>';
        	  }
        }

      mysqli_close($connect);

    ?>
  </body>
</html>
