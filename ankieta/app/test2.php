<?php
require_once('pytanie.class.php');
require_once('ankieta.class.php');       
        
/*
        $db = new mysqli('localhost', 'lukasz', 'Sx76QfRZvw@SQL', 'ankieta');

        $sql = "INSERT INTO Nazwy (nazwa) VALUES ('kierownik');";
        $db->query($sql);

        $sql = "INSERT INTO Nazwy (nazwa) VALUES ('pracownik');";
        $db->query($sql);

        $db->close();
*/

        
        /*
        $pytania = array();
        $pytania[] = new Pytanie('wycieczka', '1', 'Czy podobała Ci się wycieczka ?');
        $pytania[] = new Pytanie('wycieczka', '2', 'Czy podobał Ci hotel w którym nocowaliście ?');
        $pytania[] = new Pytanie('wycieczka', '3', 'Czy podobał Ci się pokój w którym nocowałeś/nocowałaś ?');
        $pytania[] = new Pytanie('wycieczka', '4', 'Czy pojechał byś prywatnie w to samo miejsce ?');
        $pytania[] = new Pytanie('wycieczka', '5', 'Czy ma dla Ciebie znaczenie miejsce do którego organizowana jest wycieczka ?');
        */

        /*
        $SQL = "INSERT INTO Pytania (pkod, pytanie) VALUES ('wycieczka','Czy podobała Ci się wycieczka ?');";
        $SQL = "INSERT INTO Pytania (pkod, pytanie) VALUES ('wycieczka','Czy podobał Ci hotel w którym nocowaliście ?');";
        $SQL = "INSERT INTO Pytania (pkod, pytanie) VALUES ('wycieczka','Czy podobał Ci się pokój w którym nocowałeś/nocowałaś ?');";
        $SQL = "INSERT INTO Pytania (pkod, pytanie) VALUES ('wycieczka','Czy pojechał byś prywatnie w to samo miejsce ?');";
        $SQL = "INSERT INTO Pytania (pkod, pytanie) VALUES ('wycieczka','Czy ma dla Ciebie znaczenie miejsce do którego organizowana jest wycieczka ?');";
        */

        echo '
        <!DOCTYPE html>

        <html lang="pl">
    
        <head>
            
            <title>Ankieta -  Kontrola Zarządcza 2018</title>
    
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    
            <meta name="viewport" content="width=device-width, initial-scale=1">
    
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

            <link rel="stylesheet" href="textarea.css">
    
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
            <script>
                function validateForm() {
                    var p1 = document.forms["Ankieta"]["p1"].value;
                    var p2 = document.forms["Ankieta"]["p2"].value;
                    var p3 = document.forms["Ankieta"]["p3"].value;
                    var p4 = document.forms["Ankieta"]["p4"].value;
                    if (p1 == "Wybierz") {
                        alert("Nie wybrano odpowiedzi w pytaniu 1!");
                        return false;
                    }
                    if (p2 == "Wybierz") {
                        alert("Nie wybrano odpowiedzi w pytaniu 2!");
                        return false;
                    }
                    if (p3 == "Wybierz") {
                        alert("Nie wybrano odpowiedzi w pytaniu 3!");
                        return false;
                    }
                    if (p4 == "Wybierz") {
                        alert("Nie wybrano odpowiedzi w pytaniu 4!");
                        return false;
                    }
    
                }
            </script>
    
        </head>
    
        <body>
    
    
    
            <div class="container">
            <form name="Ankieta" method="POST" action="wyslij.php">
        ';
        //<form name="Ankieta" action="wyslij.php" onsubmit="return validateForm()" method="post">
        
        
        // kod SQL do dodawania pytan
        //$SQL = "INSERT INTO Pytania (pkod, pytanie) VALUES ('$kode','$this->poziom');";
        $pytania = array();
        $pp = new Pytania('wycieczka');
        $pytania = $pp->czytaj_pytania_z_bazy();

        foreach($pytania as $p){
            $p->print_pytanie();
        }

        echo 
        '
        <input type="submit" value="Wyślij">
        </div>    
        </body>
        </html>
        ';
        ?>