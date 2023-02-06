<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
  <h2>Récapitulatif</h2>
  <div class="erreur">
  <?php

  #tant que inscription, regarder la valeur dans le post/la BDD et update valider_seance

    include 'connexion.php';
    $id_seance =$_POST['seance'];

    $query = "SELECT * FROM inscription WHERE idseance = $id_seance"; //On sélectionne les informations relatives à la séance
    $resultat_eleve = mysqli_query ($connect, $query);
    if (!$resultat_eleve) {
      echo 'Erreur: ' . mysqli_error($connect);
      exit; }

      while ($id_eleve = mysqli_fetch_array($resultat_eleve, MYSQLI_NUM)) //Boucle de toutes les lignes récupérées, dans l'ordre
  		{

  			$eleve = $id_eleve[1]; //On récupère l'id_eleve de la BDD
        // echo $eleve
  			$note = $_POST["$eleve"]; //On récupère la value de l'option dans validation_seance.php, on avait attribué à chaque option la value de l'id de l'élève


        $query_nom = "SELECT * FROM eleves WHERE ideleve = $eleve";
        $resultat_nom = mysqli_query ($connect, $query_nom);

        while ($eleve = mysqli_fetch_array($resultat_nom, MYSQLI_ASSOC)){
          $nom = $eleve['nom'];
          $prenom = $eleve['prenom'];
        }

  			if ($note <= 40 && $note >= 0) // On vérifie que la note est comprise entre 0 et 40
  			{
          $query_note = "UPDATE `inscription` SET note = $note WHERE ideleve = $id_eleve[1] and idseance = $id_seance;";
          /* echo $query_note; */
  				$changer_note = mysqli_query($connect, $query_note); // On entre la note si c'est le cas
  				if(!$changer_note)
  				{
  					echo "<br> Erreur :".mysqli_error($connect);
  				}

          echo"".$nom." ".$prenom." : ".$note.""; //Récapitulatif des notes après mise à jour
          echo "<br>";
  			}
  			else {
          echo "La note doit être comprise entre 0 et 40. Les notes que vous venez d'entrer ne seront pas prises en compte, merci de réessayer.";
          echo "<br> <a href='validation_seance.php' target='contenu'> Recommencer </a> ";
  		  }

        }
        echo " <br> <a href='accueil.html' target='contenu'> Retour à l'accueil </a> ";


    mysqli_close($connect);
   ?>
  </div>
  </body>
</html>
