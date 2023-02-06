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
    $query = 'UPDATE themes SET supprime = 1 WHERE idTheme = "'.$_POST['theme'].'"';
      $result = mysqli_query($connect, $query);
      if (!$result) echo mysqli_error($connect);
      else {
        echo <<< EOT
        <div class='erreur'>
        <p> Le thème a été supprimé ! </p>
        <br> <a href="accueil.html" target="contenu" > Retour vers l'accueil </a>
        </div>
        EOT;
      }
      mysqli_close($connect);

     ?>
  </body>
</html>
