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

          $idseance = $_POST['seance'];
          $ideleve = $_POST['eleve'];

          // La vérification que la séance n'est pas complète a déja été faite dans inscription_eleve

          $query = 'SELECT * FROM inscription WHERE idseance = "'.$idseance.'" and ideleve = "'.$ideleve.'"';
          $verif = mysqli_query($connect, $query);
          // Vérification que l'élève n'est pas déja inscrit
          if (!empty(mysqli_fetch_array($verif))) {
            echo "<div class ='erreur'>";
            echo "<p>Erreur: L'élève est déja inscrit à cette séance</p>";
            echo "<br> <a href='inscription_eleve.php' target='contenu'> Recommencer </a> </div>";
          }
          else {//Insertion dans la BDD inscription
            $query_result = "INSERT INTO inscription VALUES("."'$idseance'".","."'$ideleve'".","."'-1'".")";

            $result = mysqli_query($connect, $query_result); //Insertion dans la BDD

            //echo "<br><p>$query_result</p>";

            if (!$result)
            {
            echo mysqli_error($connect);
          } else {
            echo <<< EOT
            <div class='erreur'>
            <p> Requête effectuée avec succès </p>
            <br> <a href="accueil.html" target="contenu" > Retour vers l'accueil </a>
            </div>
            EOT;
          }

          }

          mysqli_close($connect);

     ?>
  </body>
</html>
