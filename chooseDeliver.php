<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: login.php");
    }
    include_once "inc/acl.php";
    include_once "inc/connection.php";
?> 
<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="description" content=""> 
        <meta name="author" content=""> 
        <title>AXA | Gestion des attestations auto</title>         
        <!-- Bootstrap Core CSS -->         
        <link href="css/bootstrap.min.css" rel="stylesheet"> 
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" />
        <!-- Custom CSS -->         
        <link href="css/sb-admin.css" rel="stylesheet"> 
        <!-- Morris Charts CSS -->         
        <link href="css/plugins/morris.css" rel="stylesheet"> 
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
            <div id="page-wrapper"> 
                <div class="container-fluid"> 
                    <!-- Page Heading -->                     
                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <h1 class="page-header"> <span>Sélectionner le type d'attestation</span> </h1> 
                            <!--<ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> tableaux
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->                             
                            <div class="row"> 
                                <div class="col-lg-12">
</div>                                 
                            </div>                             
                            <!-- /.row -->                             
                            <div class="row"> 
                                <div class="col-lg-3 col-md-6"> 
                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-file-o fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge"></div>
                                                    <div>Attestation Automobile</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="deliverCert.php?t=1">
                                            <div class="panel-footer">
                                                <span class="pull-left">Délivrer</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>                                         
                                    </div>                                     
                                </div>
                                <div class="col-lg-3 col-md-6"> 
                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-file-o fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge"></div>
                                                    <div>Carte Brune CEDEAO</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="deliverCert.php?t=2">
                                            <div class="panel-footer">
                                                <span class="pull-left">Délivrer</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>                                         
                                    </div>                                     
                                </div>
                                <div class="col-lg-3 col-md-6"> 
                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-file-o fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge"></div>
                                                    <div>Carte Verte 2 roues</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="deliverCert.php?t=3">
                                            <div class="panel-footer">
                                                <span class="pull-left">Délivrer</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>                                         
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
                                <!-- /#wrapper -->                                 
                                <!-- jQuery -->                                 
                                <script src="js/jquery.js"></script>                                 
                                <!-- Bootstrap Core JavaScript -->                                 
                                <script src="js/bootstrap.min.js"></script>                                 
                                <!-- Morris Charts JavaScript -->                                 
                                <script src="js/plugins/morris/raphael.min.js"></script>                                 
                                <script src="js/plugins/morris/morris.min.js"></script>                                 
                                <script src="js/plugins/morris/morris-data.js"></script>                                 
    </body>     
</html>