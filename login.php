<?php
    session_start();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>AXA-CI | LG2A</title>
        <meta name="description" content="Application de gestion des attestations auto - AXACI" />
        <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        <meta name="author" content="Codrops" /> 
        <link rel="stylesheet" type="text/css" href="css/login-style.css" />
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" />
        <link href="css/bootstrap.min.css" rel="stylesheet"> 
        <!-- Custom CSS -->         
        <link href="css/sb-admin.css" rel="stylesheet"> 
        
        <!-- Custom Fonts -->         
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
        <script src="js/modernizr.custom.63321.js"></script>
        <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <!--/ Codrops top bar -->
            <header>
                <img src="images/logo_256_256.ico" width="100" height="100" class="img-head" />
                <h1>AXA-CI | <strong>LG2A</strong></h1>
            </header>
            <section class="main">
                <form class="form-3" action="connect.php" method="post">
                    <p class="clearfix"><label for="login">Login</label><input type="text" name="userID" id="login" placeholder="Login"></p>
                    <p class="clearfix"><label for="password">Mot de passe</label><input type="password" name="userPass" id="password" placeholder="Mot de passe"></p>
                    <p class="clearfix"><input type="submit" name="submit" value="Connexion"></p> 
                </form>                                                ​
            </section>
            <header>
                <h1 class="softname">Logiciel de gestion des attestions autos - AXA Côte d'Ivoire</h1>
            </header>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script> 
    </body>
</html>