<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: index.php");
    }

    include_once "inc/acl.php";
    include_once "inc/models.php";

    /*
    if (!in_array($_SESSION['type'], $acl_view_sups)) {
        header("location: accesDenied.php");
    }
    */
    
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
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" />
        <link href="css/bootstrap.min.css" rel="stylesheet"> 
        <!-- Custom CSS -->         
        <link href="css/sb-admin.css" rel="stylesheet"> 
        <!-- Custom Fonts -->         
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
        <!-- Datatable -->
        <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
        <!-- jquery Confirm -->
        <link rel="stylesheet" type="text/css" href="css/jquery-confirm.css" />
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
                            <h1 class="page-header">Paramètres</h1> 
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
                                        <div class="panel-heading"></div>                                         
                                        <div class="panel-body">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#password">Changement de mot de passe</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="password" class="tab-pane fade in active">
                                                    <form role="form" method="POST" action="changePassword.php">   
                                                        <div class="form-group"> 
                                                            <label class="control-label" for="exampleInputPassword1">Mot de passe actuel</label>
                                                            <input type="password" class="form-control" name="oldpass" placeholder="Saisissez le mot de passe actuel" required="required">
                                                        </div>
                                                        <div class="form-group"> 
                                                            <label class="control-label" for="exampleInputPassword1">Nouveau mot de passe</label>
                                                            <input type="password" class="form-control" name="newpass" placeholder="Saisissez le nouveau mot de passe" required="required">
                                                        </div>
                                                        <div class="form-group"> 
                                                            <label class="control-label" for="exampleInputPassword1">Confirmez le mot de passe</label>
                                                            <input type="password" class="form-control" name="confirmpass" placeholder="Saisissez le nouveau mot de passe à nouveau" required="required">
                                                        </div>                                                 
                                                        <button type="submit" class="btn btn-success">Modifier</button>
                                                    </form>         
                                                </div>
                                            </div>     
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
                                                           
    </body>     
</html>
