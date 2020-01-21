<!DOCTYPE html>

<html lang="en">

    <head>

        <title>Ankieta</title>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <link rel="stylesheet" href="textarea.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     </head>

    <body>
    <div class="container">
    <div class="blackonwhite">
    <h3>
<?php
require('config.php');
require_once('ankieta.class.php');
$ankieter = new Ankieter($conn);
$ankieter->wczytaj_przeslana_ankiete();
#$ankieter->wyswietl_ankiety();
$ankieter->zapisz_ankiete_do_bazy();
?>
    </h3>
    </div>
    </div>
    </body>
</html>