    <?php
    require('config.php');
    require('pytanie.class.php');
    require('ankieta.class.php');


        $poziom = null;
        $found = false;
        $passcode = $_POST["passcode"];
        
        
        $zsql = "SELECT poziom FROM Kody WHERE kod = '$passcode'";

        if(!$wynik = $conn->query($zsql)){
            die('Unable to execute querry [' . $conn->connect_error . ']');
        }

        while($row = $wynik->fetch_assoc()){
            $poziom = $row['poziom'];
        }

        $pytania = array();
        $pp = new Pytania($conn, $poziom);
        $pytania = $pp->czytaj_pytania_z_bazy();
    
    ?>
    
    <!DOCTYPE html>

    <html lang="pl">

    <head>

        <title>Ankieta</title>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <link rel="stylesheet" href="textarea.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
        <?php
        $i=1;
        echo 'function validateForm() {
            '; 
        foreach ($pytania as $pytanie){
            echo 'var p'.$pytanie->nr.' = document.forms["Ankieta"]["'.$i.'"].value;
            ';
            $i=$i+3;
        }
        
        foreach ($pytania as $pytanie){
            echo '
                if (p'.$pytanie->nr.' == 3) {
                    alert("Nie udzielono odpowiedzi na pytanie: \n'.trim($pytanie->p).'");
                    return false;
                }
            ';
        }
        echo '}'

        ?>
        </script>

    </head>

    <body>



        <div class="container">

            <?php
            if ($poziom != null){
                echo '<div class="blackonwhite"><h2>Ankieta - ' . $poziom . '</h2></div>';
                echo '<form name="Ankieta" method="POST" action="wyslij.php" onsubmit="return validateForm()">';
                echo '<input type="hidden" name="passcode" value="'.$passcode.'">';
                

                foreach($pytania as $p){
                    $p->print_pytanie();
                }
                echo '<input class="wyslij" type="submit" value="Wyślij ->">';
            } else {
                die('<div class="blackonwhite"><h3>Najprawdopodobniej wpisany został zły kod.</h3> <br />Jeśli błąd będzie się powtarzał skonataktuj się z:<br /> <b>Biurem ds. Informatyzacji<br />tel:542882039 wew 38</b></div>');
            }

            ?>

            


        </div>    
    </body>

</html>














