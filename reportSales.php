<?php
try
{
    session_start();
    
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: index.php");
    }

    include_once "inc/acl.php";
    include_once "inc/models.php";

    if (!in_array($_SESSION['type'], $acl_reports)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/connection.php";

    //Recupération des dates du filtre

    $debut = (isset($_POST['debut'])) ? $_POST['debut'] : 'null';
    $fin = (isset($_POST['fin'])) ? $_POST['fin'] : 'null';

    if (empty($_POST['debut']) && empty($_POST['fin'])) {
        $req = $bdd->prepare($models['sales_report']);
        $req -> execute(array($_SESSION['userID']));

        $req2 = $bdd->prepare($models['sales_report']);
        $req2 -> execute(array($_SESSION['userID']));
    } else {
        $req = $bdd->prepare($models['sales_report_filtered']);
        $req -> execute(array($_SESSION['userID'], $debut, $fin));

        $req2 = $bdd->prepare($models['sales_report_filtered']);
        $req2 -> execute(array($_SESSION['userID'], $debut, $fin));
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
        <title>AXA | LG2A</title>         
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
                            <h1 class="page-header hidden-print">Rapport des ventes d'attestation</h1> 
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
                                                    <label>Selectionner la période des ventes : </label>
                                                    <input type="date" class="form-control" name="debut" value=<?php echo "\"".$debut."\"" ?>>
                                                </div>
                                                <div class="form-group">
                                                    <input type="date" class="form-control" name="fin" value=<?php echo "\"".$fin."\"" ?>>
                                                </div>
                                                <button type="submit" class="btn btn-success">Filtrer</button>
                                                <!--
                                                <a href="JavaScript:window.print()" class="hidden-print">
                                                    <button type="button" class="btn btn-success"><i class="fa fa-fw fa-print"></i> Imprimer</button>
                                                </a>
                                                -->
                                                <a href=<?php echo "\"salesExport.php?start=".$debut."&fin=".$fin."\"" ?> class="hidden-print">
                                                    <button type="button" class="btn btn-success"><i class="fa fa-fw fa-file-excel-o"></i> Télécharger</button>
                                                </a>
                                            </form>
                                        </div>                                         
                                        <div class="panel-body">
                                            <div class="alert alert-info alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <i class="fa fa-info-circle"></i>  <strong>Vous pouvez télécharger le rapport des ventes en cliquant sur le bouton "Télécharger". Vous pouvez également filtrer les dates avant le téléchargement.</strong> <a href="#" class="alert-link"></a> 
                                            </div>
                                            <!--
                                            <table class="table table-bordered table-hover table-striped table-sales" id="viewTable"> 
                                                <thead> 
                                                    <tr>
                                                        <th>Numéro d'attesation</th>
                                                        <th>Type</th>
                                                        <th>Police</th>
                                                        <th>Début</th>
                                                        <th>Fin</th>
                                                        <th>Client</th>
                                                        <th>Producteur</th>
                                                        <th>Prime</th>
                                                    </tr>                                                     
                                                </thead>                                                 
                                                <tbody> 
                                                    <?php
                                                        if (null == ($req2->fetch())) {
                                                            ?> 
                                                            <tr class="active"> 
                                                                <td colspan="12"><p class="text-center">Aucune commande enregistrée</p></td> 
                                                            </tr>                                             
                                                            <?php
                                                        }
                                                        while ($ok = $req->fetch())
                                                            {
                                                        ?> 
                                                            <tr>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['attestation']); ?> 
                                                                </td>
                                                                <td class="text-uppercase">
                                                                    <?php
                                                                        $typeAtt = "";
                                                                        switch (htmlspecialchars($ok['type'])) {
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
                                                                    <?php echo htmlspecialchars($ok['police']); ?> 
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['debut']); ?>
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['fin']); ?>
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['client']); ?>
                                                                </td>
                                                                <td>
                                                                <?php 
                                                                    $req3 = $bdd->prepare($models['seller']);
                                                                    $req3 -> execute(array($ok['vente_commercial']));
                                                                    $ok3 = $req3->fetch();
                                                                ?>
                                                                <span><?php echo $ok3['user_prenom']." ".$ok3['user_nom']." - ".$ok3['user_mat']; ?></span>
                                                                </td>
                                                                <td> 
                                                                    <?php echo htmlspecialchars($ok['prime']); ?> 
                                                                </td>
                                                            </tr>                             
                                                        <?php
                                                            }
                                                        ?>                                                     
                                                </tbody>
                                            </table>                                             
                                            <div class="text-right"></div>
                                            -->                                          
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
