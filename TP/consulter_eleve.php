<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h2>Récapitulatif</h2>
    <?php
    //Affichage des infos d'un élève
    include 'connexion.php';
    $ideleve = $_POST['eleve'];

    if(empty($ideleve)){//vérification des champs
      echo" <div class='erreur'> <p>Veuillez sélectionner un élève afin d'afficher ses informations. </p> ";
      echo "<br> <a href='consultation_eleve.html' target='contenu'> Recommencer </a> </div>";
      exit;
      }
    else {
      //sélection de l'élève dans la BDD
      $selection_query = "SELECT * FROM eleves WHERE ideleve = $ideleve";
      $resultat=mysqli_query ($connect, $selection_query);
      if (!$resultat) {
        echo 'Impossible d\'exécuter la requête : ' . mysqli_error($connect);
        exit; }

      $infos = mysqli_fetch_array($resultat);

      echo "<table border ='2' class ='carte-etu'>";
      echo "<tr> <td rowspan='2'> <img src='profile.png' width='50'> </td>  ";
      echo "<td>Nom : </td><td>".$infos['nom']."</td></tr>";
      echo "<tr><td>Prénom : </td><td>".$infos['prenom']."</td></tr>";
      echo "<tr><td colspan = '2'>Date de Naissance : </td><td>".$infos['dateNaiss']."</td></tr>";
      echo "<tr><td colspan = '2'>Date d'inscription : </td><td>".$infos['dateInscription']."</td></tr>";
      echo "</table>";
      echo " <br> <a href='accueil.html' target='contenu' class='carte-etu'> Retour à l'accueil </a> ";


    }
    mysqli_close($connect);
     ?>
  </body>
</html>
