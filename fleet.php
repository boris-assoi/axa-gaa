<?php
try {
    session_start();
    if (!isset($_SESSION['connect']) or $_SESSION['connect'] != 1) {
        header("location: login.php");
    }
    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_sales)) {
        header("location: accesDenied.php");
    }

    include_once "inc/connection.php";
    include_once "inc/models.php";

    $sId = $_GET['sId'];

    $req  = $bdd->prepare($models['sale_details_for_pos_operation']);
    $req->execute(array($_SESSION['userID'], $sId));
    $ok = $req->fetch();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>LG2A LG2A</title>
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
                            <h1 class="page-header"> <span>Ajouter le véhicule à la flotte</span> </h1>
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
                                            <form role="form" method="POST" action="toFleet.php">
                                                <div class="form-group">
                                                    <label class="control-label" for="formInput28">Sélectionner le type d'attestation</label>
                                                    <span class="text-uppercase">
                                                        <span> - Disponibilité - </span>
                                                        <?php
                                                            $reqx = $bdd->prepare($models['dispoAuto']);
                                                            $reqx->execute(array($_SESSION['userID']));
                                                            $okx = $reqx->fetch();
                                                            echo "Automobile : <span class=\"badge alert-success text-uppercase\">" . htmlspecialchars($okx['nbre']) . "</span>";
                                                            $reqx->closeCursor();

                                                            ?>
                                                        <?php
                                                            $reqx = $bdd->prepare($models['dispoBrune']);
                                                            $reqx->execute(array($_SESSION['userID']));
                                                            $okx = $reqx->fetch();
                                                            echo "Brune CEDEAO: <span class=\"badge alert-success text-uppercase\">" . htmlspecialchars($okx['nbre']) . "</span>";
                                                            $req->closeCursor();

                                                            ?>
                                                        <?php
                                                            $reqx = $bdd->prepare($models['dispoVerte']);
                                                            $reqx->execute(array($_SESSION['userID']));
                                                            $okx = $reqx->fetch();
                                                            echo "Carte Verte : <span class=\"badge alert-success text-uppercase\">" . htmlspecialchars($okx['nbre']) . "</span>";
                                                            $reqx->closeCursor();

                                                            ?>
                                                    </span>
                                                    <select id="typAtt" class="form-control" name="typAtt">
                                                        <?php
                                                            $request = "SELECT * FROM type_attestation ORDER BY type_attestation_lib ASC";
                                                            $reqx = $bdd->query($request);
                                                            while ($okx = $reqx->fetch()) {
                                                                echo "<option class=\"text-uppercase\">" . htmlspecialchars($okx['type_attestation_lib']) . "</option>";
                                                            }
                                                            $reqx->closeCursor();
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Police N°</label>
                                                    <input type="text" class="form-control" name="pol" maxlength="10" placeholder="Entrer le numéro de la police" required="required" disabled value=<?php echo "\"" . $ok['police_num'] . "\"" ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Nom du client</label>
                                                    <input type="text" class="form-control" name="nom" placeholder="Entrer le nom du client" required="required" value=<?php echo "\"" . $ok['client_nom'] . "\"" ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Genre du véhicule</label>
                                                    <select id="formInput28" class="form-control" name="carGenre" required="required">
                                                        <?php
                                                            $request = 'SELECT type_vehicule_lib FROM type_vehicule';
                                                            $req = $bdd->query($request);
                                                            while ($ok = $req->fetch()) {
                                                                echo "<option class=\"\">" . htmlspecialchars($ok['type_vehicule_lib']) . "</option>";
                                                            }
                                                            $req->closeCursor();
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Marque du véhicule</label>
                                                    <input type="text" class="form-control" placeholder="Entrer la marque du véhicule" name="carMake" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Immatriculation du véhicule</label>
                                                    <input type="text" class="form-control" name="imat" placeholder="Entrer le numéro d'immatriculation du véhicule" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Numéro de chassis</label>
                                                    <input type="text" class="form-control" name="chassis" placeholder="Entrer le numéro de chassis du véhicule">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="formInput28">Catégorie du véhicule</label>
                                                    <select id="formInput28" class="form-control" name="cat" required="required">
                                                        <?php
                                                            $request = 'SELECT cat_vehicule_id FROM categorie_vehicule';
                                                            $req = $bdd->query($request);
                                                            while ($ok = $req->fetch()) {
                                                                echo "<option class=\"\"> Catégorie " . htmlspecialchars($ok['cat_vehicule_id']) . "</option>";
                                                            }
                                                            $req->closeCursor();
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="exampleInputPassword1">Montant de l'attestation</label>
                                                    <input type="number" class="form-control" name="amount" placeholder="Entrer le montant" required="required">
                                                </div>
                                                <input type="text" hidden="" value=<?php echo "\"" . $sId . "\"" ?> name="vente_id">
                                                <input type="text" hidden="" value="1" name="vType">
                                                <button type="submit" class="btn btn-success">Ajouter</button>
                                                <a href="mySales.php" class="hidden-print">
                                                    <button type="button" class="btn btn-danger">Terminer</button>
                                                </a>
                                            </form>
                                            <div class="text-right"></div>
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