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
    /* Recupérer les données du formulaire
    */

      $nom_theme = $_POST["nom_theme"];
      if (empty($_POST["nom_theme"])) {
        $msgError ="Veuillez insérer le nom du thème";
        echo "<div class ='erreur'> <p>".$msgError."</p>";
        echo "<a href='ajout_eleve.html' target='contenu'> Recommencer </a> </div>";
      };
      $description = $_POST["description"];
      if (empty($_POST["description"])) {
        $msgError ="Veuillez insérer la description du thème";
        echo "<div class ='erreur'> <p>".$msgError."</p>";
        echo "<a href='ajout_eleve.html' target='contenu'> Recommencer </a> </div>";
      };

      include('connexion.php'); //insère le texte de connexion.php à cet endroit là

      $nom_theme_ech = mysqli_real_escape_string($connect,$nom_theme);    //protège la BDD contre les commandes entrées dans les champs de saisie
      $description_ech = mysqli_real_escape_string($connect,$description);

      $query_verif ="SELECT * FROM themes WHERE nom = '$nom_theme_ech' AND supprime = 1";
      $result_verif= mysqli_query($connect,$query_verif);
      //On récupère les thèmes supprimés du même nom

      if (!$result_verif) {
       echo 'Impossible d\'exécuter la requête : ' . mysqli_error($connect);
       exit; } //On vérifie que result_verif existe

      if (!empty(mysqli_fetch_array($result_verif)))  {
        $query_reactivation= "UPDATE themes SET supprime=0 WHERE nom ='$nom_theme_ech'";
        $result_reactivation = mysqli_query($connect,$query_reactivation);

        echo <<< EOT
        <div class = 'erreur'>
        <p> Un thème précédemment supprimé portant le même nom a été retrouvé dans la base de donnée. </p>
        <p> Ce thème a été rétabli. </p>
        <p> Remarque: La description récupérée peut être différente.
        <br> <a href='accueil.html' target='contenu'> Retour à l'accueil </a> </div>
        EOT;
      }
        else {
          $query = "INSERT INTO themes VALUES (NULL, \"$nom_theme_ech\" , FALSE,  \"$description_ech\")";
        // echo "<br>$query<br>";

          $result = mysqli_query($connect, $query);
          if (!$result)
          {
            echo "<br> Erreur: ".mysqli_error($connect);
          }

            echo "<div class='erreur'> <p> Requête effectuée avec succès. Ajout du thème suivant:</p>";
            echo "<p> $nom_theme: $description</p>";
            echo " <br> <a href='accueil.html' target='contenu'> Retour à l'accueil </a> </div>";
        }




      mysqli_close($connect);


     ?>

  </body>
</html>
