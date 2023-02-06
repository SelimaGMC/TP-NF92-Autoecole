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

      if(empty($_POST['seance']) or empty($_POST['eleve'])){ //vérification des champs
          echo"<p> Un élève ou une séance n'ont pas été sélectionnés.</p>";
          echo "<br> <a href='desinscription_seance.php' target='contenu'> Recommencer </a> ";
        }
      else{//récupération des informations
          $ideleve = $_POST['eleve'];
          $idseance = $_POST['seance'];

          $inscription_query = "SELECT * FROM inscription WHERE ideleve = $ideleve and idseance = $idseance";
          $result_inscription = mysqli_query($connect, $inscription_query);
          //Récupération de l'inscription

          if (!$result_inscription) {
            echo 'Erreur : ' . mysqli_error($connect);
            exit; }

          if (empty(mysqli_fetch_array($result_inscription))) { //Si le tuple est vide, l'élève n'est pas inscrit

            echo "<div class='erreur'> <p> L'élève sélectionné n'est pas inscrit à cette séance </p>";
            echo " <br> <a href='desinscription_seance.php' target='contenu'> Recommencer </a> </div>";
          }
          else { //si l'élève est inscrit on le supprime
            $supprime_query = "DELETE FROM inscription WHERE ideleve = $ideleve AND idseance = $idseance";
            // echo $supprime_query
            $supprime = mysqli_query($connect, $supprime_query);
            if (!$supprime){
              echo "<br> Erreur ".mysqli_error($connect);
              exit;
              }

            echo "<div class='erreur'> <p> L'élève est bien désinscrit de la séance ! </p> ";
            echo '<br> <a href="accueil.html" target="contenu" > Retour vers l\'accueil </a> </div>';
            }
          }


      mysqli_close($connect);
     ?>
  </body>
</html>
