<?php
session_start();
require('config.php');
require('user.class.php');

$users = array();
$users[] = new User($app_user, $app_pass);


if(isset($_GET["action"])){
    $action = $_GET["action"];
    }
else{
    $action='';
}


if(isset($_POST["g_ile"])) $g_ile = $_POST["g_ile"];
if(isset($_POST["g_poziom"])) $g_poziom = $_POST["g_poziom"];

if (!isset($_SESSION["zalogowany"])) {
    if (isset($_POST['login']) && isset($_POST['pass'])){

        foreach ($users as $user){
            if (($_POST['login']==$user->login) && ($_POST['pass']==$user->pass)){
                $_SESSION['zalogowany'] = 'admin';
                $_SESSION['user'] = $user->login;
                header('Location: admin2.php');
                die();
            }          
        header('Location: admin.php');
        die();
        } 
    }
} 
else if ((isset($_SESSION["zalogowany"])) && ($_SESSION["zalogowany"]=='admin')){
    if (isset($_POST['wyloguj'])){
        if ($_POST['wyloguj'] == 'tak'){
            unset($_SESSION['zalogoway']);
            session_destroy();
            header('Location: admin.php');
            die();
        }
    }

require('pytanie.class.php');
require('ankieta.class.php');
require('nazwa.class.php');

require_once('generator.php');

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title>Ankieta -  Panel Administracyjny</title>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="passcode2.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
    </script>

    </head>

<body>
        <div class="container">
            <h2>Ankieta - Panel Administracyjny</h2>
            <FORM action="admin2.php" method="POST"><label>Jesteś zalogowany jako: <? echo $_SESSION['user'] ?></label><input type="hidden" name="wyloguj" value="tak"><input type="submit" value="Wyloguj" style="margin-left:10px; border: 1px solid #ccc; background: #333; color:#fff; border-radius: 5px;"></FORM>

            <table style="width:100%">
                <tr>
                    <th>Ankiety</th>
                    <th>Kody</th>
                    <th>Wyniki</th>
                </tr>
                <tr>
                    <td><a href="?action=nowa_ankieta_s1">Nowa Ankieta</a></td>
                    <td><a href="?action=generuj">Generuj Kody</a></td>
                    <td><a href="?action=przegladaj">Wybierz Ankietę</a></td>
                </tr>
                <tr>
                    <td><a href="?action=usun_ankiete">Usun Ankietę</a></td>
                    <td><a href="?action=usun_kody">Usun Kody</a></td>
                    <td><a href="?action=pankieta">Pokaż Pojedyńczą Ankietę</a></td>
                </tr>
                <tr>
                    <td><a href="?action=pokaz_ankiety">Pokaż Ankiety</a></td>
                    <td><a href="?action=przegladajKody">Pokaż Kody</a></td>
                </tr>    
            </table>



            <?php

                switch($action){
                    
                    case 'nowa_ankieta_s1':
                        echo '<h3>Nowa Ankieta</h3><hr />';
                        echo '<form action="?action=nowa_ankieta_s2" method="post">';
                        echo '
                        <fieldset>
                        <legend>Nowa Ankieta</legend>      
                        <label for="nazwa">Nazwa (max 17 znaków):</label>
                        <input type="text" id="nazwa" name="nazwa" maxlength="17" />
                
                        <label for="l_pytan">Liczba pytań:</label>
                        <input type="number" id="l_pytan" name="l_pytan" placeholder="Min: 1, max: 99" min="1" max="99" />
                        </fieldset>
                        ';
                        echo '<input type="submit" value="Dalej">';
                        echo '</form>';
                        break;

                    case'nowa_ankieta_s2':

                        echo '<h3>Nowa Ankieta</h3><hr />';
                        echo 'Nazwa: '.$_POST['nazwa']. '<br />liczba pytan: '.$_POST['l_pytan'];
                        echo '<form action="wyslij2.php" method="POST">';
                        
                        for($i = 1 ; $i <= $_POST['l_pytan'] ; $i++){
                            echo '
                            <label>Pytanie nr: '.$i.'</label><br />
                            <textarea rows="4" cols="50" name="'.$i.'"></textarea><br />
                            ';
                        }

                        echo '
                        <input type="hidden" name="nazwa" value="'.$_POST['nazwa'].'">
                        <input type="submit" value="Dodaj Ankietę" style="margin:10px; padding:10px; border: 1px solid #ccc; background: #333; color:#fff; border-radius: 5px;">
                        ';
                        echo '</form>';

                        break;

                    case 'pokaz_ankiety':

                        echo '<h3>Pokaż Ankiety:</h3><hr />';
                        $n = new Nazwa($conn);
                        $nazwy = $n->czytaj_nazwy_z_bazy();
                        echo '
                        <form method="GET">
                        <input type="hidden" name="action" value="pokaz_ankiety">
                        <select name="wybierz_ankiete">
                        ';
                        foreach ($nazwy as $nazwa){
                            echo '<option value="'. $nazwa->nazwa .'">'.$nazwa->nazwa.'</option>';
                        }
                        echo'                  
                        </select>
                        <input type="submit" value="Wybierz">
                        </form>
                        ';
                        if (isset($_GET['wybierz_ankiete'])){
                            echo '<hr /><p>Ankieta : <b style="font-size: 1.5em">' . $_GET['wybierz_ankiete'] . '</b></p><hr />';
                            $a = new Pytania($conn, $_GET['wybierz_ankiete']);
                            $p = $a->czytaj_pytania_z_bazy();
                            $i = 1;
                            foreach($p as $pytanie){
                                echo $i . '. ' . $pytanie->p . ' <br />';
                                $i++;
                            }
                        }


                        break;

                    case 'przegladaj':
                        echo('<h3>Przeglądaj</h3><hr />');
                        $n = new Nazwa($conn);
                        $nazwy = $n->czytaj_nazwy_z_bazy();
                        echo '
                        <form method="GET">
                        <input type="hidden" name="action" value="przegladaj">
                        <select name="wybierz_ankiete">
                        ';
                        foreach ($nazwy as $nazwa){
                            echo '<option value="'. $nazwa->nazwa .'">'.$nazwa->nazwa.'</option>';
                        }
                        echo'                  
                        </select>
                        <input type="submit" value="Wybierz">
                        </form>
                        ';
                        if (isset($_GET['wybierz_ankiete'])){
                            $a = new Ankieter($conn);
                            $pytania = $a->pobierz_pytania_z_bazy($_GET['wybierz_ankiete']);
                            echo '<hr /><p>Ankieta : <b style="font-size: 1.5em">' . $_GET['wybierz_ankiete'] . '</b></p><hr />';
                            $i=1;
                            foreach ($pytania as $p){
                                
                                echo '<b><h4>' . $i.'.' . $p->p . '</h4></b><br />';
                                $la = $a->policz_ankiety_w_bazie($p->nazwa, $p->nr);
                                echo 'Liczba udzielonych odpowiedzi:' . $la . '<br />';
                                $lnt = $a->policz_ankiety_w_bazie_na_tak($p->nazwa, $p->nr);
                                echo 'tak:'. $lnt;

                                echo '<br />';

                                echo 'nie:' . ($la - $lnt);

                                echo '<br />';

                                echo '<h4>Uwagi do pytania:</h4>';
                                $aa = $a->czytaj_ankiety_z_bazy_z_uwagami($p->nazwa, $p->nr);
                                $j=1;
                                foreach ($aa as $aaa){
                                    if ($aaa->odpowiedz == 1){
                                        $o = 'tak';
                                    }
                                    else{
                                        $o = 'nie';
                                    } 
                                    echo  $j . '. -> '.$o. ' -> ' . $aaa->uwagi . '<br />';
                                    $j++;
                                    }                            
                                echo '<br />';
                                echo '<br /><br /><hr /><br /><br />';
                                $i++;
                                }
                                $ankieta = $_GET['wybierz_ankiete'];
                            echo 
                                '
                                <form method="POST" action="printall.php" target="_blank">
                                <input type="hidden" name="ankieta" value="'.$ankieta.'">
                                <input type="submit" value="Drukuj">
                                </form><br />
                                '; 
                        }
                        break;
                    
                    case 'generuj':
                        $n = new Nazwa($conn);
                        $nazwy = $n->czytaj_nazwy_z_bazy();
                        echo('<h3>Generuj</h3><hr />');
                        echo '
                        <form action="?action=wgeneruj" method="post">
                        Ile | Poziom <br />
                        <input type="number" id="g_ile" name="g_ile" placeholder="Min: 1, max: 99" min="1" max="99" />
                        <select name="g_poziom">
                        ';
                        foreach ($nazwy as $nazwa){
                            echo '<option value="'. $nazwa->nazwa .'">'.$nazwa->nazwa.'</option>';
                        }
                        echo'                  
                        </select>
                        <br><br>
                        <input type="submit" value="Generuj">
                        </form>
                        ';
                      
                        break;

                    case 'przegladajKody':
                        echo('<h3>Kody:</h3><hr />');
                        $keyloader = new KeyCodesLoader($conn);
                        $keyloader->loadKeyCodes();
                        $keyloader->showKeyCodes();
                        break;

                    case 'wgeneruj':
                        if (isset($g_ile) && isset($g_poziom)){
                            $gen = new KeyCodesGenerator($conn);
                            $gen->Generate($g_ile, 10, $g_poziom);
                            $gen->showKeyCodes();
                            $gen->AddToDB();
                        }
                        break;

                    case 'pankieta':
                            echo '<h3>Pokaż Ankiete:</h3><hr />';
                            $kody = array();
                            $ank = array();

                             $zsql = "SELECT kod FROM Tracking";

                            if(!$wynik = $conn->query($zsql)){
                                die('Unable to execute querry [' . $conn->connect_error . ']');
                            }

                            while($row = $wynik->fetch_assoc()){
                                $kody[] = $row['kod'];
                            }
                            echo '
                            <form method="GET">
                            <input type="hidden" name="action" value="pankieta">
                            <select name="wybierz_p_ankiete">
                            ';
                            foreach ($kody as $kod){
                                echo '<option value="'. $kod .'">'.$kod.'</option>';
                            }
                            echo'                  
                            </select>
                            <input type="submit" value="Wybierz">
                            </form>
                            ';
                            if (isset($_GET['wybierz_p_ankiete'])){
                                $ankietakod = $_GET['wybierz_p_ankiete'];
                                echo '<hr /><p>Ankieta : <b style="font-size: 1.5em">' . $ankietakod . '</b></p><hr />';
                                
                                if($conn->connect_errno > 0 ){
                                    die('Unable to connect to database [' . $conn->connect_error . ']');
                                }                             
                                $sql = "SELECT nazwa, odpowiedz, uwagi FROM Ankiety WHERE kod = '$ankietakod' ORDER BY `pytanie`";
                                if(!$wynik = $conn->query($sql)){
                                    die('Unable to execute querry [' . $conn->connect_error . ']');
                                }
                                $wp = 1;
                                while($row = $wynik->fetch_assoc()){
                                    $ank[] = array("nazwa"=> $row['nazwa'], "odpowiedz"=>$row['odpowiedz'], "uwagi"=>$row['uwagi']);
                                }

                                echo '<h3>'. $ank[0]['nazwa'] .'</h3>';
                                                             
                                $a = new Pytania($conn, $ank[0]['nazwa']);
                                $p = $a->czytaj_pytania_z_bazy();
                                $i = 0;
                                foreach($p as $pytanie){
                                    if ($ank[$i]['odpowiedz'] == 1){
                                        $odp =  'TAK';
                                    }
                                    else{
                                        $odp = 'NIE';
                                    }
                                    echo $i+1 . '. ' . $pytanie->p . ' <br /><b>Odpowiedź:</b>  ' . $odp . ' <br /><b>Uwagi:</b> ' . $ank[$i]['uwagi'] . '<br /><hr />';
                                    $i++;
                                }
                                echo 
                                '
                                <form method="POST" action="print.php" target="_blank">
                                <input type="hidden" name="ankietakod" value="'.$ankietakod.'">
                                <input type="submit" value="Drukuj">
                                </form><br />
                                ';
                            }
                        break;

                    default:
                        echo('');
                        break;
                }
            
            
            
            }
            ?>

            </div>



    </body>

</html>