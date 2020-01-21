        <?php
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

            public function print_pytanie(){
                echo '
                <div class="row">
                    <div class="col-sm-5">
                    <label>PYTANIE:</label><br />       
                        ' . $this->p . '<br />
                    </div>

                    <div class="col-sm-2">
                    <label>ODPOWIEDŹ:</label> 
                        <select class="form-control" name="' . $this->nr . '">

                            <option value="3">Wybierz</option>
                            
                            <option value="1">Tak</option>

                            <option value="0">Nie</option>

                        </select>

                    </div>
                    <div class="col-sm-5 borderleft">
                    <label>UWAGI (Jeśli nie ma pozostaw pole puste):</label>
                    <textarea name="uwagi_' . $this->nr . '"></textarea>     

                    </div>
                </div>
                <input type="hidden" name="nazwa" value="' . $this->nazwa . '">
                ';
            }
        }


        class Pytania
        {

            public $pkod;
            public $pA = array();
            public $conn;

            function __construct($conn = null, $pkod){
                $this->conn = $conn;
                $this->pkod = $pkod;
            }

            public function czytaj_pytania_z_bazy(){
                  
                $sql = "SELECT * FROM Pytania WHERE pkod = '$this->pkod'";

                if(!$wynik = $this->conn->query($sql)){
                    die('Unable to execute querry [' . $this->conn->connect_error . ']');
                }

                while($row = $wynik->fetch_assoc()){
                    $this->pA[] = new Pytanie($row['pkod'], $row['id'], $row['pytanie']);
                }
                return $this->pA;
            }
        }
?>        