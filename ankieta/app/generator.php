<?php

class KeyCodesGenerator{

    public $conn;
    private $poziom = 0;
    private $keycodes = array();

    function __construct($conn = null){
        $this->conn = $conn;
    }


    private function GenerateRandomKeyCode($dlugosc) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        
        $alphaLength = strlen($alphabet) - 1;
    
        $pass='';
        for ($i = 0; $i < $dlugosc; $i++) {
            $n = rand(0, $alphaLength);
            $pass[$i] = $alphabet[$n];
        }
        return $pass;
    }
    
    private function generateKeyCodes($ile_wygenerowac, $jak_dlugie){
        $counter = 0;
        do{
            if (isset($keycodes)) unset($keycodes);
            for ($j=0; $j<$ile_wygenerowac ; $j++){
                $keycodes[] = $this->GenerateRandomKeyCode($jak_dlugie);
            }
            $pow_max = 0;
            if (count($keycodes) > 1) {
                for ($k=0 ; $k < count($keycodes) -1 ; $k++){
                    $pow = count(array_keys($keycodes, $keycodes[$k]));
                    if ($pow > $pow_max){
                        $pow_max = $pow;
                    }   
                }
            $counter +=1;
            }
            else $pow_max = 1;
        } while ($pow_max != 1);
        echo $counter;
        return $keycodes;
    }

    public function showKeyCodes(){
        echo '<table class="table table-dark">';
        foreach ($this->keycodes as $kode){
            echo '<tr><td style="border: 1px solid #000; padding:10px;">' . $kode . '</td><td style="border: 1px solid #000; padding:10px;">' . $this->poziom .'</td></tr>';
        }
        echo '</table>';
    }

    public function Generate($ile, $dlugosc, $poziom){
        if(isset($this->keycodes)) unset($this->keycodes);
        $this->keycodes = $this->generateKeyCodes($ile, $dlugosc);
        $this->poziom = $poziom;
    }

    public function AddToDB(){
        $sql = "";
        foreach ($this->keycodes as $kode){
            $sql.= "INSERT INTO Kody (kod, poziom) VALUES ('$kode','$this->poziom');";
        }

        if ($this->conn->multi_query($sql) === TRUE) {
            echo "SUKCES! Nowe kody dodane do bazydanych";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

class KeyCodesLoader{
    
    public $conn;
    private $keycodes = array();

    function __construct($conn = null){
        $this->conn = $conn;
    }

    public function loadKeyCodes($poziom = null){
        
        if ($poziom == null){
            $sql = "SELECT * FROM Kody";
        }
        else {
            $sql = "SELECT * FROM Kody WHERE poziom = '$poziom'";
        }
        
        if(!$wynik = $this->conn->query($sql)){
            die('Unable to execute querry [' . $this->conn->connect_error . ']');
        }

        while($row = $wynik->fetch_assoc()){
            $this->keycodes[] = $row;
        }
    }

    public function showKeyCodes(){
        echo '<table>';
        foreach ($this->keycodes as $kode){
            echo '<tr><td style="border: 1px solid #000; padding:10px;">ID: ' . $kode['id'] . '</td><td style="border: 1px solid #000; padding:10px;">' . $kode['kod'] . '</td><td style="border: 1px solid #000; padding:10px;">' . $kode['poziom'] .'</td></tr>';
        }
        echo '</table>';
    }
}

?>