<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h1> Inscription d'un élève à une séance </h1>
    <div class="main">
    <p> Veuillez choisir un élève et une séance: </p>
    <?php
    include 'connexion.php';
      $date = date("Ymd");
      $query_seance = "SELECT * FROM seances INNER JOIN themes ON seances.idtheme=themes.idtheme and DateSeance >= $date";

      //On sélectionne toutes les séances dans le futur en ajoutant le thème
      $result_seance = mysqli_query ($connect, $query_seance);

      $query_eleve = "SELECT * FROM eleves";
      //On sélectionne toutes les eleves
      $result_eleve = mysqli_query ($connect, $query_eleve);

      if (!$result_seance) { // TOUJOURS tester le resultat de la requete
        echo mysqli_error($connect);
        exit; }

      if (!$result_eleve) { // TOUJOURS tester le resultat de la requete
        echo mysqli_error($connect);
        exit; }

      if ((mysqli_num_rows($result_seance) or mysqli_num_rows($result_eleve)) == 0) {
        //Vérification que des séances et des élèves soit définies
        echo " <p> Erreur aucun élève ou aucune séance ne sont définis </p>";
        echo "<br> <a href='ajout_eleve.html' target='contenu'> Inscrire un élève </a> ";
        echo "<a href='ajouter_eleve.php' target='contenu'> Créer une séance </a>";
      }
      else {
        //Formulaire de sélection d'élèves et de séances
        echo <<< EOT
        <FORM METHOD='POST' ACTION='inscrire_eleve.php'>
        <table>
         <tr>
          <td> Elève: </td>
          <td> <select name ='eleve'>
        EOT;
        //Affichage de tous les eleves
        while ($response_eleve = mysqli_fetch_array($result_eleve)) {
          echo "<option value=".$response_eleve['ideleve'].">".$response_eleve['nom']." ".$response_eleve['prenom']." (".$response_eleve['dateNaiss'].")</option>";
        }
        echo <<< EOT
          </select> </td>
        </tr>
        <tr>
          <td> Séance: </td>
          <td> <select name ='seance'>
        EOT;
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

          $places_dispo = $response_seance['EffMax'] - $effectif_nombre;

          if ($places_dispo > 0){ // On n'affiche pas les séances où les places ne sont plus disponibles
            echo "<option value=".$response_seance['idseance'].">".$response_seance['nom']." (".$response_seance['DateSeance'].")</option><br>";

          }
        }

        echo <<< EOT
          </select> </td>
        </tr>
        <tr>
          <td> <input type='reset' name='clear' value='Annuler'> </td>
          <td> <input type='submit' name='Send' value='Inscrire'> </td>
          </tr>
        </form>

        EOT;
      }


      mysqli_close($connect);
     ?>
   </div>
  </body>
</html>
