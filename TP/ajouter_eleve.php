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
    /* Recupérer les données du formulaire
    */

      $nom = $_POST["nom"];
      if (empty($_POST["nom"])) {
        $msgError ="Veuillez insérer le nom de l'élève";
        echo "<div class ='erreur'> <p>".$msgError."</p>";
        echo "<a href='ajout_eleve.html' target='contenu'> Recommencer </a> </div>";
      };
      $prenom = $_POST["prenom"];
      if (empty($_POST["prenom"])) {
        $msgError ="Veuillez insérer le prénom de l'élève";
        echo "<div class ='erreur'> <p>".$msgError."</p>";
        echo "<a href='ajout_eleve.html' target='contenu'> Recommencer </a> </div>";
      };
      $ddn = $_POST["ddn"];

    /* Determiner la date du jour.
    */
    date_default_timezone_set('Europe/Paris');
    $date = date("Y\-m\-j");  /* "\": le caractère suivant ne doit pas être interprété comme un symbole/opérateur.
                                  "*/
    if ($ddn> $date){
      echo "<div class ='erreur'> <p> L'élève n'est pas encore né!</p>";
      echo "<a href='ajout_eleve.html' target='contenu'> Recommencer </a> </div>";
    }
     else {
     include('connexion.php'); //insère le texte de connexion.php à cet endroit là

     $nom_ech = mysqli_real_escape_string($connect,$nom);    //protège la BDD contre les commandes entrées dans les champs de saisie
     $prenom_ech = mysqli_real_escape_string($connect,$prenom);
     $ddn_ech = mysqli_real_escape_string($connect,$ddn);

     $query ="SELECT * FROM eleves WHERE nom='$nom_ech' AND prenom='$prenom_ech' ";
     // echo" <br> $query <br> ";
     $same  = mysqli_query($connect, $query);
     $num = mysqli_num_rows($same);
      if($num == 0) {   //à revoir le num= 0

       $query = "INSERT INTO eleves VALUES (NULL, \"$nom_ech\" , \"$prenom_ech\" , \"$ddn_ech\" , \"$date\")";
       // echo "<br> num = 0: $query <br>";
       // important echo a faire systematiquement, c'est impose !

       $result = mysqli_query($connect, $query);
       if (!$result) {
         echo "<br> No result:  ".mysqli_error($connect);
       }


        else {
          echo " <div class='erreur'> <p> Inscription: Le $date: Inscription de l'élève $nom $prenom né(e) le $ddn </p>";
          echo " <br> <a href='accueil.html' target='contenu'> Retour à l'accueil </a> </div>";
        }

     }
       else {
         echo  <<< EOT
         <div class="erreur">
         <p> Un élève existe déjà sous le même nom, voulez-vous inscrire un nouvel élève $nom_ech $prenom_ech ? </p>
         <br>
         <form method="POST" action="valider_eleve.php">

         <input type="hidden" name="nom" value="$nom_ech">
         <input type="hidden" name="prenom" value="$prenom_ech">
         <input type="hidden" name="ddn" value="$ddn_ech">

         <input type='reset' name='clear' value='Non'>
         <input type='submit' name='Send' value='Oui'>
         </form>
         </div>
        EOT;

       }

       mysqli_close($connect);
}
     ?>

  </body>
</html>
