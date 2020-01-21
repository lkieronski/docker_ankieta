<!DOCTYPE html>

    <html lang="en">

    <head>

        <title>Ankieta</title>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
        <?php
        $pytania = array('firstname', 'lastname');
        echo 'function validateForm() {'; 
        foreach ($pytania as $pytanie){
            echo 'var '.$pytanie.' = document.forms["Ankieta"]["'.$pytanie.'"].value;';
        }
        
        foreach ($pytania as $pytanie){
            echo '
                if ('.$pytanie.' == 3) {
                    alert("'.$pytanie.'");
                    return false;
                }
            ';
        }
        echo '}'

        ?>
        </script>

    </head>

    <body>


<?php
if (isset($_POST['sendform'])){
    echo 'Form send<br/>';
}
?>
<form name="Ankieta" action="testscript.php" method="POST" onsubmit="return validateForm()">
<label for="nazwa">Nazwa</label>
<?php
foreach ($pytania as $pytanie){
    echo '<select class="form-control" name="' . $pytanie . '">
    <option value="3">Wybierz</option> 
    <option value="1">Tak</option>
    <option value="0">Nie</option>
    </select>
    ';
}
?>

<input type="submit" value="OK" name="sendform">

</form>

    </body>
</html>