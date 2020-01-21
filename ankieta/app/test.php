<?php

require('config.php');

$db = new mysqli($dbci['host'], $dbci['user'], $dbci['pass'], $dbci['db']);

if($db->connect_errno > 0 ){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
  
$sql = "SELECT * FROM Pytania";

if(!$wynik = $db->query($sql)){
    die('Unable to execute querry [' . $db->connect_error . ']');
}

while($row = $wynik->fetch_assoc()){
    echo($row['pkod'].' - '.$row['id'].' - '.$row['pytanie']);
}
$db->close();