    <?php

    require_once('ankieta.class.php');

    ?>
    <!DOCTYPE html>

    <html lang="en">

    <head>

        <title>Ankieta -  Panel Administracyjny</title>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        </head>

    <body>



        <div class="container">
        
        <?php

        $ankieter = new Ankieter();
        echo 'liczb ankieta: ' . $ankieter->policz_ankiety_w_bazie('wycieczka') . '<br />';
        $ankieter->czytaj_ankiety_z_bazy_z_uwagami('wycieczka');
        $ankieter->wyswietl_ankiety();

        ?>

        </div>
            



    </body>

</html>