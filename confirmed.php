<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: index.php");
    }

    include_once "inc/acl.php";

    //Récupération du message
    $m = $_GET['m'];
?> 
    <!DOCTYPE html>
<html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>Accès refusé | AXA LG2A</title>
            <!-- Bootstrap Core CSS -->
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="css/sb-admin.css" rel="stylesheet">
            <!-- Custom Fonts -->
            <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        </head>
        <body>
            <div id="wrapper">
                <?php include_once "inc/menu.php"; ?>
            </nav>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12"></div>
                    </div>
                    <a href="#"></a>
                    <div class="row">
                        <div class="alert alert-success">
                            <h1> <i class="fa fa-fw fa-check-circle"></i> <strong> <?php echo $m; ?><br></strong></h1>
                        </div>
                        <a href="index.php" class="hidden-print">
                            <button type="button" class="btn">Retourner à l'accueil</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php
            }
            catch (Exception $e)
            {
                die('Erreur:'.$e->getMessage());
            }
        ?> 
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    </body>
