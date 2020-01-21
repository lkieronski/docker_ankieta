<?php
session_start();
if (isset($_SESSION['zalogowany'])){
    header('Location: admin2.php');
}
else {
   
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
        <form class="form-signin" action="/admin2.php" method="POST">
            <h2 class="form-signin-heading">Proszę się zalogować</h2>
            <label for="inputEmail" class="sr-only">Login</label>
            <input type="login" id="inputEmail" class="form-control" name="login" placeholder="Login" required autofocus>
            <label for="inputPassword" class="sr-only">Hasło</label>
            <input type="password" id="inputPassword" class="form-control" name="pass" placeholder="Hasło" required>
            <div class="checkbox">
            </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>