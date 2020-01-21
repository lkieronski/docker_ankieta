<?php
class Nazwa
{
    private $id;
    private $nazwa;
    public $conn;
    

    function __construct($conn = null, $id = null, $nazwa = null){
        $this->id = $id;
        $this->nazwa = $nazwa;
        $this->conn = $conn;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
    }
    
    public function czytaj_nazwy_z_bazy(){
        $nazwy = array();
        $sql = "SELECT * FROM Nazwy;";
        if(!$wynik = $this->conn->query($sql)){
            die('Unable to execute querry [' . $this->conn->connect_error . ']');
        }

        while($row = $wynik->fetch_assoc()){
            $nazwy[] = new Nazwa(null, $row['id'], $row['nazwa']);
        }

        return $nazwy;
    }

    public function wczytaj_nazwe_z_formularza(){
        $this->id = $_POST['id'];
        $this->nazwa = $_POST['nazwa'];
    }

    public function zapisz_nazwe_w_bazie(){
        $sql = "INSERT INTO Nazwy (nazwa) VALUES ('$this->nazwa');";
        if(!$wynik = $this->conn->query($sql)){
            die('Unable to execute querry [' . $this->conn->connect_error . ']');
        }
    }
}

?>