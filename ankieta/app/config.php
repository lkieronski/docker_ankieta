<?php
$host = getenv('SQL_HOST');
$db = getenv('SQL_DB');
$user = getenv('SQL_USER');
$pass = getenv('SQL_PASS');
$app_user = getenv('APP_USER');
$app_pass = getenv('APP_PASS');

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_errno){
     die('Nie udało się połączyć z bazą danych');  
}


?>