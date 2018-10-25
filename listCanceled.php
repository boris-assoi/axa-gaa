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

    $req  = $bdd->prepare($models['list_annulation']);
    $req -> execute(array($_SESSION['userID']));

    $req2  = $bdd->prepare($models['list_annulation']);
    $req2 -> execute(array($_SESSION['userID']));
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
                            <h1 class="page-header"> Liste des attestations annulées</h1> 
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
                                                    <tr> 
                                                        <th>N° Attestation</th>
                                                        <th>Statut</th>
                                                        <th>Type</th>
                                                        <th>Date d'annulation</th>
                                                        <th>Statut</th>
                                                    </tr>                                                     
                                                </thead>                                                 
                                                <tbody> 
                                                    <?php
                                                        if (null == ($req2->fetch())) {
                                                            ?> 
                                                            <tr class="active"> 
                                                                <td colspan="10"><p class="text-center">Aucune attestation annulée</p></td> 
                                                            </tr>                                             
                                                            <?php
                                                        }
                                                        while ($ok = $req->fetch())
                                                            {
                                                        ?> 
                                                            <tr> 
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['attestation_num']); ?> 
                                                                </td>                                                 
                                                                <td> 
                                                                    <span class="badge alert-success text-uppercase"><?php echo htmlspecialchars($ok['attestation_statut']); ?></span> 
                                                                </td>
                                                                <td> 
                                                                    <span class="text-uppercase"><?php echo htmlspecialchars($ok['type_attestation_lib']); ?></span> 
                                                                </td>                                                 
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['dateFr']); ?> 
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-info" href=<?php echo "\"status.php?att=".htmlspecialchars($ok['attestation_num'])."\"" ?>>Voir le statut</a>
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
                                <!-- Datatables JavaScript -->
                                <script type="text/javascript" src="js/datatables.min.js"></script>
                                <!-- jquery Confirm -->
                                <script type="text/javascript" src="js/jquery-confirm.js"></script>
                                <script>
                                    $(document).ready(function(){
                                        $('#viewTable').DataTable({
                                            language: {
                                                processing:     "Traitement en cours...",
                                                search:         "Rechercher&nbsp;:",
                                                lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
                                                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                                                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                                infoPostFix:    "",
                                                loadingRecords: "Chargement en cours...",
                                                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                                emptyTable:     "Aucune donnée disponible dans le tableau",
                                                paginate: {
                                                    first:      "Premier",
                                                    previous:   "Pr&eacute;c&eacute;dent",
                                                    next:       "Suivant",
                                                    last:       "Dernier"
                                                },
                                                aria: {
                                                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                                                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                                                }
                                            }
                                        });
                                    });
                                </script>
                                <script type="text/javascript">
                                 $('a.cancel').confirm({
                                     content: "Voulez-vous annuler cette attestation?",
                                });
                                $('a.cancel').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href');
                                         }
                                     }
                                 });
                                </script>                                 
    </body>     
</html>
