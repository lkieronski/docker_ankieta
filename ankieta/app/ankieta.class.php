<?php
class Ankieta
{

            private $id;
            private $nazwa;
            private $pytanie;
            private $odpowiedz;
            private $uwagi;
            private $passcode;


            function __construct($id = null, $nazwa, $pytanie, $odpowiedz, $uwagi){
                $this->id = $id;
                $this->nazwa = $nazwa;
                $this->pytanie = $pytanie;
                $this->odpowiedz = $odpowiedz;
                $this->uwagi = $uwagi;

                if (isset($_POST['passcode'])){
                    $this->passcode = $_POST['passcode'];
                }
            }

            public function __get($property) {
                if (property_exists($this, $property)) {
                  return $this->$property;
                }
            }

            public function print_ankieta(){
                echo $this->nazwa . ' _ ' . $this->pytanie . ' _ ' . $this->odpowiedz . ' _ ' . $this->uwagi . ' _ ' . $this->passcode . '<br />';
            }
}

class Ankieter
{
    public $conn;
    public $ankiety = array();

    function __construct($conn = null){
        $this->conn = $conn;
    }

    public function czytaj_ankiety_z_bazy($nazwa , $pytanie = null){
                

                if($this->conn->connect_errno > 0 ){
                    die('Unable to connect to database [' . $this->conn->connect_error . ']');
                }
                if  ($pytanie != null){
                    $sql = "SELECT * FROM Ankiety WHERE nazwa = '$nazwa' AND pytanie = '$pytanie'";
                }
                else{
                    $sql = "SELECT * FROM Ankiety WHERE nazwa = '$nazwa'";
                }
                if(!$wynik = $this->conn->query($sql)){
                    die('Unable to execute querry [' . $this->conn->connect_error . ']');
                }

                while($row = $wynik->fetch_assoc()){
                    $this->ankiety[] = new Ankieta($row['id'], $row['nazwa'], $row['pytanie'], $row['odpowiedz'], $row['uwagi']);
                }
                
                return $this->ankiety;
            }


            public function pobierz_pytania_z_bazy($pytanie){

                if($this->conn->connect_errno > 0 ){
                    die('Unable to connect to database [' . $this->conn->connect_error . ']');
                }
                $sql = "SELECT * FROM Pytania WHERE pkod = '$pytanie'";

                if(!$wynik = $this->conn->query($sql)){
                    die('Unable to execute querry [' . $this->conn->connect_error . ']');
                }

                while($row = $wynik->fetch_assoc()){
                    $pytania[] = new Pytanie($row['pkod'], $row['id'], $row['pytanie']);
                }

                

                return $pytania;
            }


            public function czytaj_ankiety_z_bazy_z_uwagami($nazwa, $pytanie){
                $ankiety = array();

                if($this->conn->connect_errno > 0 ){
                    die('Unable to connect to database [' . $this->conn->connect_error . ']');
                }
                $sql = "SELECT * FROM Ankiety WHERE nazwa = '$nazwa' AND pytanie = '$pytanie' AND uwagi <> ''";
                if(!$wynik = $this->conn->query($sql)){
                    die('Unable to execute querry [' . $this->conn->connect_error . ']');
                }

                while($row = $wynik->fetch_assoc()){
                    $ankiety[] = new Ankieta($row['id'], $row['nazwa'], $row['pytanie'], $row['odpowiedz'], $row['uwagi']);
                }
                
                return $ankiety;
            }

            public function policz_ankiety_w_bazie_na_tak($nazwa, $pytanie){

                if($this->conn->connect_errno > 0 ){
                    die('Unable to connect to database [' . $this->conn->connect_error . ']');
                }
                $sql = "SELECT COUNT(id) AS liczbaankiet FROM Ankiety WHERE nazwa = '$nazwa' AND pytanie = '$pytanie' AND odpowiedz = '1';";
                if(!$wynik = $this->conn->query($sql)){
                    die('Unable to execute querry [' . $this->conn->connect_error . ']');
                }

                while($row = $wynik->fetch_assoc()){
                    $liczba = $row['liczbaankiet'];
                }
                
                return $liczba;
            }

            public function policz_ankiety_w_bazie($nazwa, $pytanie){

                if($this->conn->connect_errno > 0 ){
                    die('Unable to connect to database [' . $this->conn->connect_error . ']');
                }
                $sql = "SELECT COUNT(id) AS liczbaankiet FROM Ankiety WHERE nazwa = '$nazwa' AND pytanie = '$pytanie';";
                if(!$wynik = $this->conn->query($sql)){
                    die('Unable to execute querry [' . $this->conn->connect_error . ']');
                }

                while($row = $wynik->fetch_assoc()){
                    $liczba = $row['liczbaankiet'];
                }
                
                return $liczba;
            }

            public function wczytaj_przeslana_ankiete(){
                if (isset($_POST['nazwa'])){
                    foreach ($_POST as $key=>$value){
                        $z = explode("_", $key);
                        if ($key == 'passcode') {continue;};
                        if ($key == 'nazwa') { $nazwa = $value; }
                        else if ($z[0] == 'uwagi'){
                            $value = strip_tags($value);
                            $uwagi[] = $value;
                            }
                        else {
                            $pytanie[] = $key;
                            $odpowiedz[] = $value;
                        }
                    }
                    for($i = 0 ; $i < count($pytanie) ; $i++){
                        $this->ankiety[] = new Ankieta(null, $nazwa, $pytanie[$i], $odpowiedz[$i], $uwagi[$i]);
                    }
                }
            }

            public function wyswietl_ankiety(){
                foreach ($this->ankiety as $ankieta){
                    $ankieta->print_ankieta();
                }   
            }

            public function zapisz_ankiete_do_bazy(){


                if (isset($_POST['passcode'])){
                    $passcode = $_POST['passcode'];
                    $found = false;

                    $zsql = "SELECT poziom FROM Kody WHERE kod = '$passcode'";

                    if(!$wynik = $this->conn->query($zsql)){
                        die('Unable to execute querry [' . $this->conn->connect_error . ']');
                    }

                    while($row = $wynik->fetch_assoc()){
                        $found = true;
                    }
                    if ($found){
                        if($this->conn->connect_errno > 0 ){
                            die('Unable to connect to database [' . $this->conn->connect_error . ']');
                        }
                        foreach ($this->ankiety as $ankieta){
                            $uwaga = $this->conn->real_escape_string($ankieta->uwagi);
                            $sql = "INSERT INTO Ankiety (nazwa, pytanie, odpowiedz, uwagi, kod) VALUES ('$ankieta->nazwa','$ankieta->pytanie','$ankieta->odpowiedz','$uwaga','$ankieta->passcode');";
                            #echo $sql . '<br />';
                            if(!$wynik = $this->conn->query($sql)){
                                die('Unable to execute querry [' . $this->conn->connect_error . ']');
                            }
                            
                        }
                        
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $sql = "INSERT INTO Tracking (kod, ip) VALUES ('$passcode','$ip');";
                        if(!$wynik = $this->conn->query($sql)){
                            die('Unable to execute querry [' . $this->conn->connect_error . ']');
                        }

                        $sql = "DELETE FROM Kody WHERE kod = '$passcode'";
                        if(!$wynik = $this->conn->query($sql)){
                            die('Unable to execute querry - DELETE PASSCODE [' . $this->conn->connect_error . ']');
                        }
                        echo 'Dziękujemy za wypełnienie ankiety.';
                    }
                    else {
                        echo 'Kod został już wykorzystany!';
                    }
                    
                }
            }
}
?>