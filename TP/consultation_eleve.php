<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
<body>
  <h1>Consulter élève</h1>
  <div class="main">
  <?php
    //Récupération des données des élèves
    include 'connexion.php';

    $resultat_eleve_query = "SELECT * FROM eleves";
    $resultat_eleve = mysqli_query ($connect, $resultat_eleve_query);
    if (!$resultat_eleve) { //On teste le résultat de la requête
      echo 'Impossible d\'exécuter la requête : ' . mysqli_error($connect);
      echo "<br> <a href='consultation_eleve.php' target='contenu'> Recommencer </a> ";
      exit; }

    echo <<< EOT
    <p> Veuillez sélectionner un élève: </p>
    <table>
    <tr>
    <form method="post" action="consulter_eleve.php">
      <td> <select name="eleve">
    EOT;
    // Selection d'un élève
    while ($select_eleve = mysqli_fetch_array($resultat_eleve)) { //Affichage de tous les élèves
      echo "<option value=".$select_eleve['ideleve'].">".$select_eleve['nom']." ".$select_eleve['prenom']." (".$select_eleve['dateNaiss'].") </option>";
    }
    // L'ajout d'une date de naissance permet de différencier les homonymes
    echo <<< EOT
    </select> </td> </tr>
    <tr>
      <td> <input type='reset' value='Annuler'>
      <input type='submit' name='Send' value='Consulter'> </td>
    </tr>
    </form>
      </table>
    EOT;

    mysqli_close($connect);
  ?>
  </div>
</body>
</html>
