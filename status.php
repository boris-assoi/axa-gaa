<?php
try {
    session_start();
    if (!isset($_SESSION['connect']) or $_SESSION['connect'] != 1) {
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

    $att = $_GET['att'];

    if ($_SESSION['type'] == "admin") {
        $req  = $bdd->prepare($models['status']);
        $req->execute(array($att));
    } else {
        $req  = $bdd->prepare($models['status']);
        $req->execute(array($att, $_SESSION['userID']));
    }

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
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" />
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
            <div id="page-wrapper">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> Statut de l'attestation <b>N° <?php echo $att; ?></b></h1>
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
                                            <table class="table table-bordered table-hover table-striped" id="viewTable">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Unité de gestion</th>
                                                        <th>Agence</th>
                                                        <th>Producteur</th>
                                                        <th>Informations sur la vente</th>
                                                        <th>Situation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        while ($ok = $req->fetch()) {
                                                            ?>
                                                        <tr class="text-center bg-warning">
                                                            <td>
                                                                <?php
                                                                        if ($ok['attestation_ug']) {
                                                                            $req2  = $bdd->prepare("SELECT ug_nom, ug_r_comm, user_nom, user_prenom, user_mat FROM unit_gestion, user WHERE ug_r_comm = user_id AND ug_id = ?");
                                                                            $req2->execute(array($ok['attestation_ug']));
                                                                            while ($ok2 = $req2->fetch()) {
                                                                                echo htmlspecialchars($ok2['ug_nom']) . "<br>" . htmlspecialchars($ok2['user_prenom']) . " " . htmlspecialchars($ok2['user_nom']) . " - " . htmlspecialchars($ok2['user_mat']);
                                                                            }
                                                                            $req2->closeCursor();
                                                                        } else {
                                                                            echo "Non attribué à l'unité de gestion";
                                                                        }

                                                                        ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                        if ($ok['attestation_pos']) {
                                                                            $req2  = $bdd->prepare("SELECT pos_nom, pos_superviseur, user_nom, user_prenom, user_mat FROM pos, user WHERE pos_superviseur = user_id AND pos_id = ?");
                                                                            $req2->execute(array($ok['attestation_pos']));
                                                                            while ($ok2 = $req2->fetch()) {
                                                                                echo htmlspecialchars($ok2['pos_nom']) . "<br>" . htmlspecialchars($ok2['user_prenom']) . " " . htmlspecialchars($ok2['user_nom']) . " - " . htmlspecialchars($ok2['user_mat']);
                                                                            }
                                                                            $req2->closeCursor();
                                                                        } else {
                                                                            echo "Non attribué au point de vente";
                                                                        }
                                                                        ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                        if ($ok['attestation_comm']) {
                                                                            $req2  = $bdd->prepare("SELECT user_nom, user_prenom, user_mat FROM user WHERE user_id = ?");
                                                                            $req2->execute(array($ok['attestation_comm']));
                                                                            while ($ok2 = $req2->fetch()) {
                                                                                echo htmlspecialchars($ok2['user_prenom']) . " " . htmlspecialchars($ok2['user_nom']) . " - " . htmlspecialchars($ok2['user_mat']);
                                                                            }
                                                                            $req2->closeCursor();
                                                                        } else {
                                                                            echo "Non attribué au commercial";
                                                                        }
                                                                        ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                        if ($ok['attestation_vente']) {
                                                                            $req2  = $bdd->prepare($models['status_sale']);
                                                                            $req2->execute(array($ok['attestation_comm'], $ok['attestation_vente']));
                                                                            while ($ok2 = $req2->fetch()) {
                                                                                echo "Vendu le : <b>" . htmlspecialchars($ok2['vente_date']) . "</b><br>Numéro de police: <b>" . htmlspecialchars($ok2['police_num']) . "</b>";
                                                                            }
                                                                            $req2->closeCursor();
                                                                        } else {
                                                                            echo "Non vendu";
                                                                        }
                                                                        ?>
                                                            </td>
                                                            <td>
                                                                <span class="badge alert-success text-uppercase"><?php echo htmlspecialchars($ok['attestation_statut']); ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
                                            <a href="listCertificate.php" class="hidden-print">
                                                <button type="button" class="btn btn-info"><i class="fa fa-fw fa-arrow-left"></i> Retour</button>
                                            </a>
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
    </body>

    </html>