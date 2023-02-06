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
    include('connexion.php');

    $nom= $_POST["nom"];
    $prenom= $_POST["prenom"];
    $ddn= $_POST["ddn"];
    $date = date("Y\-m\-j");

    $query = "INSERT INTO eleves VALUES (NULL, '$nom' , '$prenom' , '$ddn' , '$date')";
     // echo "<br> Query: $query<br>";
    $result = mysqli_query($connect, $query);
    if (!$result)
    {
      echo "<br> Erreur d'exécution de la requête: ".mysqli_error($connect);
                                    }


    else {
      echo "<div class ='erreur'> <p> Le $date: Inscription de l'élève $nom $prenom né(e) le $ddn </p>";
      echo " <br> <a href='accueil.html' target='contenu'> Retour à l'accueil </a> </div>";
    }

     ?>
  </body>
</html>
