<?php
try
{
    session_start();
    
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: index.php");
    }

    include_once "inc/acl.php";
    include_once "inc/models.php";

    if (!in_array($_SESSION['type'], $acl_sales)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/connection.php";

    //Récupération du numéro de police recherché
    $find = (isset($_POST['find'])) ? $_POST['find'] : '';

    if (empty($_POST['find'])) {
        $req = $bdd->prepare($models['sales_by_seller']);
        $req -> execute(array($_SESSION['userID']));

        $req2 = $bdd->prepare($models['sales_by_seller']);
        $req2 -> execute(array($_SESSION['userID'])); 
    } else {
        $req = $bdd->prepare($models['sales_by_seller_filtered']);
        $req -> bindParam(':user', $_SESSION['userID'], PDO::PARAM_INT);
        $req -> bindParam(':find', $find, PDO::PARAM_STR);
        $req -> execute();

        $req2 = $bdd->prepare($models['sales_by_seller_filtered']);
        $req2 -> bindParam(':user', $_SESSION['userID'], PDO::PARAM_INT);
        $req2 -> bindParam(':find', $find, PDO::PARAM_STR);
        $req2 -> execute();
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
        <title>AXA | Gestion des attestations auto</title>         
        <!-- Bootstrap Core CSS -->         
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" /> 
        <link href="css/jquery-confirm.css" rel="stylesheet">
        <script src="js/jquery-confirm.js"></script>        
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
                            <h1 class="page-header">Mes ventes</h1> 
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
                                            <form class="form-inline" method="POST" action="">
                                                <div class="form-group">
                                                    <label>Entrer votre recherche : </label>
                                                    <input type="text" class="form-control" name="find" value=<?php echo "\"".$find."\"" ?>>
                                                </div>
                                                <button type="submit" class="btn btn-warning"><i class="fa fa-fw fa-search"></i> Rechercher</button>
                                                <a href="sellCert.php" class="hidden-print">
                                                    <button type="button" class="btn btn-success"><i class="fa fa-fw fa-plus"></i> Nouvelle vente</button>
                                                </a>
                                                <a href="sales.php" class="hidden-print">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-fw fa-shopping-cart"></i> Toutes les ventes</button>
                                                </a>
                                            </form>
                                        </div>                                        
                                        <div class="panel-body">
                                            <table class="table table-bordered table-hover table-striped table-sales" id="viewTable"> 
                                                <thead> 
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Police</th>
                                                        <th>Début</th>
                                                        <th>Fin</th>
                                                        <th>Client</th>
                                                        <th>Marque</th>
                                                        <th>Matricule</th>
                                                        <th>Prime</th>
                                                        <th>Type</th>
                                                        <th>Mvt</th>
                                                        <th>Opérateur</th>
                                                        <th width="270px">Actions</th>
                                                    </tr>                                                     
                                                </thead>                                                 
                                                <tbody> 
                                                    <?php
                                                        if (null == ($req2->fetch())) {
                                                            ?> 
                                                            <tr class="active"> 
                                                                <td colspan="12"><p class="text-center">Aucune vente pour aujourd'hui</p></td> 
                                                            </tr>                                             
                                                            <?php
                                                        }
                                                        while ($ok = $req->fetch())
                                                            {
                                                        ?> 
                                                            <tr>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['vente_date']); ?> 
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['police_num']); ?> 
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['pol_date_deb']); ?> 
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['pol_date_fin']); ?> 
                                                                </td>
                                                                <td> 
                                                                    <span class="text-uppercase"><?php echo htmlspecialchars($ok['client_nom']); ?></span>  
                                                                </td>
                                                                <td> 
                                                                    <span class="text-uppercase"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></span> 
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['vehicule_mat']); ?>
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['vente_montant']); ?> 
                                                                </td>
                                                                <td class="text-uppercase">
                                                                    <?php
                                                                        $typeAtt = "";
                                                                        switch (htmlspecialchars($ok['type_attestation_lib'])) {
                                                                            case 'automobile':
                                                                                $typeAtt = "AUTO";
                                                                                break;
                                                                            
                                                                            case 'carte brune CEDEAO':
                                                                                $typeAtt = "BRUNE";
                                                                                break;

                                                                            case 'carte verte 2 roues':
                                                                                $typeAtt = "VERTE";
                                                                                break;

                                                                            default:
                                                                                # code...
                                                                                break;
                                                                        }
                                                                    ?>
                                                                    <span class="badge alert-primary text-uppercase"><?php echo $typeAtt; ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $typeAbbr = "";
                                                                        switch (htmlspecialchars($ok['type_vente_lib'])) {
                                                                            case 'nouvelle affaire':
                                                                                $typeAbbr = "NA";
                                                                                break;
                                                                            
                                                                            case 'renouvellement':
                                                                                $typeAbbr = "RN";
                                                                                break;

                                                                            case 'renouvellement externe':
                                                                                $typeAbbr = "RE";
                                                                                break;

                                                                            default:
                                                                                # code...
                                                                                break;
                                                                        }
                                                                    ?>
                                                                    <span class="badge alert-info text-uppercase"><?php echo $typeAbbr; ?></span>
                                                                </td>
                                                                <td>
                                                                <?php 
                                                                    $req3 = $bdd->prepare($models['seller']);
                                                                    $req3 -> execute(array($ok['vente_commercial']));
                                                                    $ok3 = $req3->fetch();
                                                                ?>
                                                                <span><?php echo $ok3['user_prenom']." ".$ok3['user_nom']." - ".$ok3['user_mat']; ?></span>
                                                                </td>
                                                                <?php
                                                                    $req3->closeCursor();
                                                                    if (in_array($_SESSION['type'], $acl_cert_deliverer)) {
                                                                        $req3 = $bdd->prepare($models['cert_to_deliver']);
                                                                        $req3 -> execute(array($ok['type_attestation_lib'],$_SESSION['userID']));
                                                                        $ok3 = $req3->fetch();

                                                                        $req4 = $bdd->prepare($models['cb_to_deliver']);
                                                                        $req4 -> execute(array($_SESSION['userID']));
                                                                        $ok4 = $req4->fetch();  
                                                                    }
                                                                ?>
                                                                <td>
                                                                    <?php 
                                                                        if (in_array($_SESSION['type'], $acl_cert_deliverer)) {
                                                                            ?>
                                                                            <a target="blank" title="Imprimer l'attestation" class="printatt btn btn-info" data-title="Imprimer?" data-att=<?php echo "\"".htmlspecialchars($ok3['attestation_num'])."\"" ?> href=<?php echo "\"print\attest_auto\\1.php?att=".htmlspecialchars($ok3['attestation_num'])."&vid=".htmlspecialchars($ok['vente_id'])."&pid=".htmlspecialchars($ok['police_item_id'])."\"" ?>><i class="fa fa-fw fa-file"></i></a>
                                                                            <a target="blank" title="Imprimer la carte brune" class="printcb btn btn-warning" data-title="Imprimer la carte brune?" href=<?php echo "\"print\attest_brune\\1.php?att=".htmlspecialchars($ok4['attestation_num'])."&vid=".htmlspecialchars($ok['vente_id'])."&pid=".htmlspecialchars($ok['police_item_id'])."\"" ?>><i class="fa fa-fw fa-file-o"></i></a>
                                                                            <a title="Renouveller l'attestation" class="renew btn btn-primary" data-title="Renouveller?" href=<?php echo "\"renewCert.php?sId=".htmlspecialchars($ok['vente_id'])."\"" ?>><i class="fa fa-fw fa-refresh"></i></a>
                                                                            <a title="Ajouter un véhicule à la flotte" class="toFleet btn btn-mutedr" data-title="Ajouter à la flotte?" href=<?php echo "\"fleet.php?sId=".htmlspecialchars($ok['vente_id'])."\"" ?>><i class="fa fa-fw fa-th"></i></a>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    <a title="Modifier l'attestation" class="edit btn btn-success" data-title="Modifier?" href=<?php echo "\"updateCert.php?sId=".htmlspecialchars($ok['vente_id'])."\"" ?>><i class="fa fa-fw fa-edit"></i></a>
                                                                    <?php  ?>
                                                                    <!--
                                                                    <a title="Résilier la vente" class="cancel btn btn-danger" data-title="Résilier?" href=<?php echo "\"cancelSale.php?sId=".htmlspecialchars($ok['vente_id'])."\"" ?>><i class="fa fa-fw fa-remove"></i></a>
                                                                    -->
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
                                <script type="text/javascript">
                                $('a.printatt').confirm({
                                    //var att = document.getElementByClassName();
                                     content: "Voulez-vous imprimer l'attestation <b>"+<?php echo htmlspecialchars($ok3['attestation_num']) ?>+"</b>?",
                                });
                                $('a.printatt').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href');
                                         }
                                     }
                                 });
                                $('a.printcb').confirm({
                                     content: "Voulez-vous imprimer la carte brune <b>"+<?php echo htmlspecialchars($ok4['attestation_num']) ?>+"</b>?",
                                });
                                $('a.printcb').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href');
                                         }
                                     }
                                 });
                                $('a.renew').confirm({
                                     content: "Voulez-vous renouveller la police ?",
                                });
                                $('a.renew').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href');
                                         }
                                     }
                                 });
                                $('a.edit').confirm({
                                     content: "Voulez-vous modifier l'attestation?",
                                });
                                $('a.edit').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href');
                                         }
                                     }
                                 });
                                $('a.toFleet').confirm({
                                     content: "Voulez-vous ajouter un véhicule à la flotte?",
                                });
                                $('a.toFleet').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href'); 
                                         }
                                     }
                                 });
                                $('a.cancel').confirm({
                                     content: "Voulez-vous supprimer ce lot?",
                                });
                                $('a.cancel').confirm({
                                     buttons: {
                                         hey: function(){
                                             location.href = this.$target.attr('href');
                                         }
                                     }
                                 });
                                </script> 
                                <script>
                                    $(document).ready(function(){
                                        $('#viewTable').DataTable({
                                            language: {
                                                processing:     "Traitement en cours...",
                                                search:         "Filtrer&nbsp;:",
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
    </body>     
</html>
