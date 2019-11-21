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

    $req  = $bdd->query($models['users']);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>LG2A</title>
        <!-- Bootstrap Core CSS -->
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" />
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Datatable -->
        <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
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
                            <h1 class="page-header"> Utilisateurs</h1>
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
                                            <a href="newAdmin.php" class="btn btn-info"><i class="fa fa-fw fa-plus"></i> Adminstrateur</a>
                                            <a href="newRComm.php" class="btn btn-info"><i class="fa fa-fw fa-plus"></i> Responsable Commercial</a>
                                            <a href="newSup.php" class="btn btn-info"><i class="fa fa-fw fa-plus"></i> Superviseur</a>
                                            <a href="newComm.php" class="btn btn-info"><i class="fa fa-fw fa-plus"></i> Producteur</a>
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-bordered table-hover table-striped" id="viewTable">
                                                <thead>
                                                    <tr>
                                                        <th>Matricule</th>
                                                        <th>Nom</th>
                                                        <th>Prénom(s)</th>
                                                        <th>Service</th>
                                                        <th>Ville</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        while ($ok = $req->fetch()) {
                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo htmlspecialchars($ok['user_mat']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlspecialchars($ok['user_nom']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlspecialchars($ok['user_prenom']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlspecialchars($ok['user_service']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlspecialchars($ok['user_ville']); ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                        if ($ok['userType'] == "commercial") {
                                                                            $ok['userType'] = "producteur";
                                                                        }
                                                                        ?>
                                                                <span class="badge alert-success text-uppercase"><?php echo htmlspecialchars($ok['userType']); ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
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
                            <!-- Datatables JavaScript -->
                            <script type="text/javascript" src="js/datatables.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#viewTable').DataTable({
                                        language: {
                                            processing: "Traitement en cours...",
                                            search: "Rechercher&nbsp;:",
                                            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                                            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                                            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                            infoPostFix: "",
                                            loadingRecords: "Chargement en cours...",
                                            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                            emptyTable: "Aucune donnée disponible dans le tableau",
                                            paginate: {
                                                first: "Premier",
                                                previous: "Pr&eacute;c&eacute;dent",
                                                next: "Suivant",
                                                last: "Dernier"
                                            },
                                            aria: {
                                                sortAscending: ": activer pour trier la colonne par ordre croissant",
                                                sortDescending: ": activer pour trier la colonne par ordre décroissant"
                                            }
                                        }
                                    });
                                });
                            </script>
    </body>

    </html>