<?php
    date_default_timezone_set('Europe/Paris');
    $date_auj = date("Y\-m\-d");

    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92a009';
    $dbpass = 'Nww6TlIg';
    $dbname = 'nf92a009';

    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    //la ligne suivante permet d'éviter les problèmes d'accent entre la page web et le serveur mysql
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
    ?>
