    <!DOCTYPE html>

    <html lang="en">

    <head>

        <title>Ankieta</title>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="passcode.css">
        <link rel="stylesheet" href="passcode2.css">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>

    <body>

 <div class="container">

        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="box">
                    <div class="shape1"></div>
                    <div class="shape2"></div>
                    <div class="shape3"></div>
                    <div class="shape4"></div>
                    <div class="shape5"></div>
                    <div class="shape6"></div>
                    <div class="shape7"></div>
                    <div class="float">
                        <form class="form" action="ankieta.php" method="post">
                            <div class="form-group">
                                <label for="passcode" class="text-white">
                                    SYSTEM ANKIETOWY <br />
                                    Wpisz Kod:
                                </label><br>
                                <input type="text" name="passcode" id="passcode" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-md" value="Dalej">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>

</html>














