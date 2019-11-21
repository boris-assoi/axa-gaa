<?php
try {
    session_start();
    if (!isset($_SESSION['connect']) or $_SESSION['connect'] != 1) {
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
        <title>LG2A | Gestion des attestations auto</title>
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
                            <h1 class="page-header"> <span>Enregistrer la commande</span> </h1>
                            <!--<ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> tableaux
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                            <div class="row">
                                <div class="col-lg-12"></div>
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"></div>
                                        <div class="panel-body">
                                            <form role="form" method="POST" class="myForm" action="addCertificate.php">
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputEmail1">Numéro d'attestation</label>
                                                    <input type="number" class="form-control" placeholder="Numéro de la 1ère attestation" name="nAtt" id="nAtt" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Nombre d'attestation</label>
                                                    <input type="number" class="form-control" placeholder="Nombre d'attestations" name="nbAtt" id="nbAtt" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="formInput28">Sélectionner le type d'attestation</label>

                                                    <select id="typAtt" class="form-control" name="typAtt">
                                                        <?php
                                                            $request = "SELECT * FROM type_attestation ORDER BY type_attestation_lib ASC";
                                                            $req = $bdd->query($request);
                                                            while ($ok = $req->fetch()) {
                                                                echo "<option class=\"text-uppercase\">" . htmlspecialchars($ok['type_attestation_lib']) . "</option>";
                                                            }
                                                            $req->closeCursor();
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Date de réception</label>
                                                    <input type="date" class="form-control" placeholder="Date de réception de la commande" name="dateBatch" required="required">
                                                </div>
                                                <button type="submit" class="btn btn-success validate">Enregistrer</button>
                                                <a href="JavaScript:window.history.back()" class="hidden-print">
                                                    <button type="button" class="btn btn-danger">Annuler</button>
                                                </a>
                                            </form>
                                            <div class="text-right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                </div>
                            <?php
                            } catch (Exception $e) {
                                die('Erreur:' . $e->getMessage());
                            }
                            ?>
                            <!-- /#wrapper -->
                            <!-- jQuery -->
                            <script src="js/jquery.js"></script>
                            <!-- Bootstrap Core JavaScript -->
                            <script src="js/bootstrap.min.js"></script>

                            <script src="js/jquery-confirm.js"></script>

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
                                                    content: 'Vous aller enregistrer une commande de carte <b>' + document.getElementById('typAtt').value + '</b> allant de <b>' + document.getElementById('nAtt').value + '</b> à <b>' + (parseInt(document.getElementById('nAtt').value, 10) + parseInt(document.getElementById('nbAtt').value, 10) - 1) + '</b>',
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
                                    });;
                                });
                            </script>
    </body>

    </html>