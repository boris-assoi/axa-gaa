<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: login.php");
    }
    include_once "inc/acl.php";
    
    if (!in_array($_SESSION['type'], $acl_attrib_cert)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/models.php";
    include_once "inc/connection.php";

    //Recupération des informations
    $typAtt = htmlspecialchars($_POST['typAtt']);
    $to = htmlspecialchars($_POST['to']);
    $nAtt = (int)htmlspecialchars($_POST['nAtt']);
    $nbAtt = (int)htmlspecialchars($_POST['nbAtt']);

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
                            <h1 class="page-header"> <span>Attribuer des attestations</span> </h1> 
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
                                        <div class="panel-heading"> </div>                                         
                                        <div class="panel-body">
                                            <?php
                                                if ($nbAtt == 1) {
                                                ?>
                                                    <div class="alert alert-info">
                                                        <h3>
                                                            Vous aller attribuer <b class="text-uppercase">une</b> attestation de type <b class="text-uppercase"><?php echo $typAtt; ?></b>, de numéro <b><?php echo $nAtt; ?></b> à <b class="text-uppercase"><?php echo $to; ?></b><br>
                                                            Voulez-vous confirmer?
                                                            <br>
                                                        </h3>
                                                    </div>
                                                <?php
                                                } elseif ($nbAtt > 1) {
                                                ?>
                                                    <div class="alert alert-info">
                                                        <h3>
                                                            Vous aller attribuer <b class="text-uppercase"><?php echo $nbAtt; ?></b> attestations de type <b class="text-uppercase"><?php echo $typAtt; ?></b>, allant du <b><?php echo $nAtt; ?></b> au <b><?php echo ($nAtt + $nbAtt - 1); ?></b> à <b class="text-uppercase"><?php echo $to; ?></b><br>
                                                            Voulez-vous confirmer?
                                                            <br>
                                                        </h3>
                                                    </div>
                                                <?php
                                                }
                                            ?>
                                            <form role="form" method="POST" action="attrib.php">
                                                <input type="text" hidden="" name="to" value=<?php echo "\"".$to."\"" ?>>
                                                <input type="text" hidden="" name="nAtt" value=<?php echo "\"".$nAtt."\"" ?>>
                                                <input type="text" hidden="" name="nbAtt" value=<?php echo "\"".$nbAtt."\"" ?>>
                                                <input type="text" hidden="" name="typAtt" value=<?php echo "\"".$typAtt."\"" ?>>
                                                <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#attrib">Attribuer</button>
                                                <a href="attrCertificate.php" class="hidden-print">
                                                    <button type="button" class="btn btn-danger">Annuler</button>
                                                </a>
                                            </form>                                             
                                            <div class="text-right"> 
</div>                                             
                                        </div>                                         
                                    </div>                                     
                                </div>                                 
                                <div class="col-lg-4"> </div>
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
                                <!--
                                <script type="text/javascript">
                                    $(function() {
                                      $('.myForm').submit(function(event) {
                                        event.preventDefault();
                                        var form = $(this)[0];

                                        $.confirm({
                                          columnClass: 'col-md-4 col-md-offset-4',
                                          theme: 'material',
                                          animation: 'scaleY',
                                          title: 'Confirmer',
                                          content: 'Vous allez faire une attribution de carte <b>'+document.getElementById('typAtt').value+'</b> allant de <b>'+document.getElementById('nAtt').value+'</b> à <b>'+(parseInt(document.getElementById('nAtt').value,10) + parseInt(document.getElementById('nbAtt').value, 10) - 1) +'</b>',
                                          confirmButton: 'Oui',
                                          cancelButton: 'Non',
                                          confirmButtonClass: 'btn-success',
                                          cancelButtonClass: 'btn-danger',
                                          confirm: function() {
                                            //Submit the form
                                                form.submit
                                            });
                                          },
                                          cancel: function() {
                                            //Do nothing
                                          }
                                        });
                                      });
                                    });
                                </script>  
                                -->                               
    </body>     
</html>
