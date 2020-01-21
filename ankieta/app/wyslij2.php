<?php
    require('config.php');
    
    class Pytanie
    {

        public $nazwa;
        public $p;
        public $nr;

        function __construct($nazwa, $nr, $p){
            $this->p = $p;
            $this->nazwa = $nazwa;
            $this->nr = $nr;
        }
    }

    $pytania = array();

    for ($i = 1 ; $i < count($_POST) ; $i++){
        $pytania[] = new Pytanie($_POST['nazwa'], $i, $_POST[$i]);
    }
    $sql = "INSERT INTO Nazwy (nazwa) VALUES ('".$_POST['nazwa']."');";
    if(!$wynik = $conn->query($sql)){
        die('Unable to execute querry [' . $conn->connect_error . ']');
    }
    foreach ($pytania as $pytanie){
        $sql = "INSERT INTO Pytania (pkod, pytanie) VALUES ('$pytanie->nazwa','$pytanie->p');";
        if(!$wynik = $conn->query($sql)){
            die('Unable to execute querry [' . $conn->connect_error . ']');
        }
        else {
            header('Location: admin2.php?action=pokaz_ankiety&wybierz_ankiete='.$pytanie->nazwa);
        }
    }
?>