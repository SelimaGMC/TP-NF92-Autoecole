<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <LINK REL="stylesheet" HREF="style.css" type="text/css">
  </head>
  <body>
    <h1> Suppression d'un thème </h1>
    <div class="main">
      <p> Veuillez sélectionner un thème à supprimer </p>
    <form action="supprimer_theme.php" method="post">
    <table>
    <?php
    include 'connexion.php';
    $result = mysqli_query($connect,"SELECT * FROM themes where supprime=0 ");
    echo <<< EOT

      <tr>
        <td> <label for='theme'> Thème à supprimer: </label> </td>
        </tr>
      <tr>
        <td>
        <select name='theme' id='theme'>
    EOT ;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            echo '<option value='.$row["idtheme"].'>'.$row["nom"].'</option>';
    }
    echo <<< EOT
        </select>
        </td>
      </tr>
      <tr>
        <td>
          <input type='reset' name='clear' value='Annuler'>
          <input type='submit' name='Send' value='Supprimer'>
        </td>
      </tr>

    EOT ;
    mysqli_close($connect);
     ?>
   </table>
   </form>
  </div>
  </body>
</html>
