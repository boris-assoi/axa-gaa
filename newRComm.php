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
        <link rel="stylesheet" type="text/css" href="css/login-style.css" />
        <link href="css/bootstrap.min.css" rel="stylesheet"> 
        <!-- Custom CSS -->         
        <link href="css/sb-admin.css" rel="stylesheet"> 
        <link href="css/jquery-confirm.css" rel="stylesheet">
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
                            <h1 class="page-header"> <span>Création d'un responsable commercial</span> </h1> 
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
                                <div> 
                                    <div class="panel panel-default"> 
                                        <div class="panel-heading"> 
</div>                                         
                                        <div class="panel-body"> 
                                            <form role="form" method="POST" action="addRComm.php">   
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Matricule</label>                                                     
                                                    <input type="text" class="form-control" name="mat" placeholder="Entrer le numéro matricule de l'utilisateur" required="required">
                                                </div>
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Nom</label>                                                     
                                                    <input type="text" class="form-control" name="nom" placeholder="Nom" required="required">
                                                </div>
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Prénom(s)</label>                                                     
                                                    <input type="text" class="form-control" placeholder="Prénom(s)" name="prenom" required="required"> 
                                                </div>
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Service</label>                                                     
                                                    <input type="text" class="form-control" placeholder="Service" name="service" required="required"> 
                                                </div>
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Ville</label>                                                     
                                                    <input type="text" class="form-control" name="ville" placeholder="Ville"> 
                                                </div>
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Nom d'utilisateur</label>                                                     
                                                    <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required="required"> 
                                                </div>
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Mot de passe</label>                                                     
                                                    <input type="password" class="form-control" placeholder="Mot de passe" name="password" required="required"> 
                                                </div>                                                 
                                                <button type="submit" class="btn btn-success">Créer</button>
                                                <a href="JavaScript:window.history.back()" class="hidden-print">
                                                    <button type="button" class="btn btn-danger">Annuler</button>
                                                </a>                                                 
                                            </form>                                             
                                            <div class="text-right"></div>                                             
                                        </div>                                         
                                    </div>                                     
                                </div>                                 
                                <div class="col-lg-4"> 
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

                                <script src="js/jquery-confirm.js"></script>

                                <script type="text/javascript">
                                    $('input[type=submit]').confirm({
                                        columnClass: 'col-md-4 col-md-offset-4',
                                        theme: 'white',
                                        title: 'Add',
                                        content: 'do stuff',
                                        confirmButton: 'Ok',
                                        cancelButton: 'Cancel',
                                        confirmButtonClass: 'btn-success',
                                        cancelButtonClass: 'btn-danger',
                                        confirm: function() {
                                          //Submit the form
                                          $('.subCertificate').submit();
                                        },
                                        cancel: function() {
                                          //Do nothing
                                        }
                                      });
                                </script>                                 
    </body>     
</html>
