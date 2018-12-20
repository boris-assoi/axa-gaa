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

    //Récupération du numéro de police recherché
    $find = (isset($_POST['find'])) ? $_POST['find'] : '';

    if (empty($_POST['find'])) {
        $req = $bdd->prepare($models['sales']);
        $req -> execute(array($_SESSION['userID']));

        $req2 = $bdd->prepare($models['sales']);
        $req2 -> execute(array($_SESSION['userID'])); 
    } else {
        $req = $bdd->prepare($models['sales_filtered']);
        $req -> bindParam(':user', $_SESSION['userID'], PDO::PARAM_INT);
        $req -> bindParam(':find', $find, PDO::PARAM_STR);
        $req -> execute();

        $req2 = $bdd->prepare($models['sales_filtered']);
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
         <!-- Include SmartWizard CSS -->
        <link href="dist/css/smart_wizard.css" rel="stylesheet" type="text/css" />
        <!-- Optional SmartWizard theme -->
        <link href="dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
        <link href="dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
        <link href="dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" /> 
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
                            <h1 class="page-header">Toutes les ventes</h1> 
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
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTest"><i class="fa fa-fw fa-plus"></i> Nouvelle vente</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalTest" tabindex="-1" role="dialog" aria-labelledby="modalTestLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTestLabel">Vente de police</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <!-- Smart Wizard HTML -->
                                                        <div id="smartwizard">
                                                            <ul>
                                                                <li><a href="#step-1">Souscripteur<br /><small>Informations du souscripteur</small></a></li>
                                                                <li><a href="#step-2">Police<br /><small>Informations de la police</small></a></li>
                                                                <li><a href="#step-3">Véhicule<br /><small>Informations sur le véhicule</small></a></li>
                                                                <li><a href="#step-4">Formule<br /><small>Choix de la formule</small></a></li>
                                                                <li><a href="#step-5">Confirmation<br /><small>Confirmer la vente</small></a></li>
                                                            </ul>

                                                            <div>
                                                                <div id="step-1" class="">
                                                                    <div class="form-group"> 
                                                                        <label class="control-label" for="formInput28">Sélectionner le type d'attestation</label>                                                         
                                                                        <span class="text-uppercase"> <span> - Disponibilité - </span> <?php
                                                                            $req  = $bdd->prepare($models['dispoAuto']);
                                                                            $req -> execute(array($_SESSION['userID']));
                                                                            $ok = $req->fetch();
                                                                            echo "Automobile : <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
                                                                            $req->closeCursor();
                                                                            
                                                                        ?> <?php
                                                                            $req  = $bdd->prepare($models['dispoBrune']);
                                                                            $req -> execute(array($_SESSION['userID']));
                                                                            $ok = $req->fetch();
                                                                            echo "Brune CEDEAO: <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
                                                                            $req->closeCursor();
                                                                            
                                                                        ?> <?php
                                                                            $req  = $bdd->prepare($models['dispoVerte']);
                                                                            $req -> execute(array($_SESSION['userID']));
                                                                            $ok = $req->fetch();
                                                                            echo "Carte Verte : <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
                                                                            $req->closeCursor();
                                                                            
                                                                        ?> </span> 
                                                                        <select id="typAtt" class="form-control" name="typAtt"> 
                                                                            <?php
                                                                            $request="SELECT * FROM type_attestation ORDER BY type_attestation_lib ASC";
                                                                            $req = $bdd->query($request);
                                                                            while ($ok = $req->fetch())
                                                                            {
                                                                                echo "<option class=\"text-uppercase\">".htmlspecialchars($ok['type_attestation_lib'])."</option>";    
                                                                            }
                                                                            $req->closeCursor();
                                                                        ?> 
                                                                        </select>                                                         
                                                                    </div> 
                                                                    <fieldset>
                                                                        <legend>Informations du client</legend>                                               
                                                                        <div class="form-group"> 
                                                                            <label class="control-label" for="formInput28">Sélectionner le type de client</label>                                                         
                                                                            <select id="formInput28" class="form-control" name="type"> 
                                                                                <?php
                                                                                $request='SELECT type_client_lib FROM type_client';
                                                                                $req = $bdd->query($request);
                                                                                while ($ok = $req->fetch())
                                                                                {
                                                                                    echo "<option class=\"\">".htmlspecialchars($ok['type_client_lib'])."</option>";    
                                                                                }
                                                                                $req->closeCursor();                        
                                                                            ?> 
                                                                            </select>                                                         
                                                                        </div>                                                     
                                                                        <div class="form-group"> 
                                                                            <label class="control-label" for="exampleInputPassword1">Nom du client</label>                                                         
                                                                            <input type="text" class="form-control" name="nom" placeholder="Entrer le nom du client"> 
                                                                        </div>
                                                                        <div class="form-group form-inline">              
                                                                            <select id="classe-permis" class="form-control text-uppercase" name="classe_permis">
                                                                                <option>Sélectionnez la classe d'ancienneté</option>
                                                                                <?php
                                                                                $request='SELECT lib FROM classe_permis';
                                                                                $req = $bdd->query($request);
                                                                                while ($ok = $req->fetch())
                                                                                {
                                                                                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";    
                                                                                }
                                                                                $req->closeCursor();                        
                                                                            ?> 
                                                                            </select>
                                                                            <div class="alert alert-info" id="classe-desc"></div>
                                                                            <select id="status-pro" class="form-control text-uppercase" name="status-pro"> 
                                                                                <option>Sélectionnez le statut socio-professionnel</option>
                                                                                <?php
                                                                                $request='SELECT lib, info FROM statut_socio_pro';
                                                                                $req = $bdd->query($request);
                                                                                while ($ok = $req->fetch())
                                                                                {
                                                                                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                                                                                }
                                                                                $req->closeCursor();                        
                                                                            ?> 
                                                                            </select>
                                                                            <i class="fa fa-lg fa-question-circle" data-toggle="tooltip" data-placement="auto" title="example" id="info-status-pro"></i>
                                                                            <input type="text" class="form-control" placeholder="Profession du client" name="pro"> 
                                                                            <input type="text" class="form-control" name="adresse" placeholder="Adresse du client"> 
                                                                            <input type="text" class="form-control" name="contact" placeholder="Contact du client"> 
                                                                        </div> 
                                                                    </fieldset>
                                                                </div>
                                                                <div id="step-2" class="">
                                                                    <fieldset>
                                                                        <legend>Informations sur la police</legend>                                                  
                                                                        <div class="form-group"> 
                                                                            <label class="control-label" for="exampleInputPassword1">Police N°</label>                                                         
                                                                            <input type="text" class="form-control" name="pol" maxlength="10" placeholder="Entrer le numéro de la police"> 
                                                                        </div>                                                     
                                                                        <div class="form-group form-inline"> 
                                                                            <label class="control-label" for="exampleInputPassword1">Date de début de la police</label>                                                         
                                                                            <input type="date" class="form-control" placeholder="Entrer la date de début de la police" name="poldf">
                                                                            <label class="control-label" for="exampleInputPassword1">Date de fin de la police</label>                                                         
                                                                            <input type="date" class="form-control" placeholder="Entrer la date de fin de la police" name="poldt"> 
                                                                        </div> 
                                                                    </fieldset>
                                                                </div>
                                                                <div id="step-3" class="">
                                                                    <fieldset>
                                                                        <legend>Informations du véhicule</legend>                                                 
                                                                        <div class="form-group form-inline">
                                                                            <select id="catcar" class="form-control text-uppercase" name="cat"> 
                                                                                <option>Sélectionnez la catégorie</option>
                                                                                <?php
                                                                                $request='SELECT cat_vehicule_id FROM categorie_vehicule';
                                                                                $req = $bdd->query($request);
                                                                                while ($ok = $req->fetch())
                                                                                {
                                                                                    echo "<option class=\"\">".htmlspecialchars($ok['cat_vehicule_id'])."</option>";    
                                                                                }
                                                                                $req->closeCursor();                        
                                                                                ?> 
                                                                            </select>                                                         
                                                                            <div class="alert alert-info" id="cat-desc"></div>   
                                                                            <select id="formInput28" class="form-control text-uppercase" name="carGenre">
                                                                                <option>Sélectionnez le genre du véhicule</option>
                                                                                <?php
                                                                                $request='SELECT type_vehicule_lib FROM type_vehicule';
                                                                                $req = $bdd->query($request);
                                                                                while ($ok = $req->fetch())
                                                                                {
                                                                                    echo "<option class=\"\">".htmlspecialchars($ok['type_vehicule_lib'])."</option>";
                                                                                }
                                                                                $req->closeCursor();                        
                                                                            ?> 
                                                                            </select>                                                         
                                                                            <input type="text" class="form-control" placeholder="Marque" name="carMake"> 
                                                                            <input type="text" class="form-control" name="imat" placeholder="Immatriculation"> 
                                                                            <input type="text" class="form-control" name="chassis" placeholder="Numéro de chassis"> 
                                                                        </div>                                                     
                                                                        <div class="form-group form-inline"> 
                                                                            <label class="control-label" for="exampleInputPassword1">Puissance fiscale</label><br>                                                     
                                                                        <select id="pf" class="form-control" name="pf">
                                                                            <option>Sélectionner le type de puissance fiscale</option>
                                                                            <option>Essence</option>                                                         
                                                                            <option>Diesel</option>                                                         
                                                                        </select>
                                                                        <select id="pfValue" class="form-control" name="pfValue"> 
                                                                            <option>Sélectionnez la puissance fiscale</option>
                                                                        </select>
                                                                        </div>
                                                                        <div class="form-group form-inline"> 
                                                                            <label class="control-label">Valeur du véhicule</label> 
                                                                            <input type="text" class="form-control" placeholder="Valeur catalogue" name="valCat">                                             
                                                                        </div>
                                                                        <div class="form-group"> 
                                                                            <label class="control-label">Le véhicule possède-t-il une remorque? </label> 
                                                                            <input type="checkbox" value="rem" id="rem" name="rem">                                             
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div id="step-4" class="">
                                                                    Choix de la formule
                                                                </div>
                                                                <div id="step-5" class="">
                                                                    Confirmation
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                    if (in_array($_SESSION['type'], $acl_sales)) {
                                                        ?>
                                                        <a href="mySales.php" class="hidden-print">
                                                            <button type="button" class="btn btn-info"><i class="fa fa-fw fa-shopping-cart"></i> Mes ventes</button>
                                                        </a>
                                                        <?php
                                                    }
                                                ?>
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
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    <a title="Renouveller l'attestation" class="renew btn btn-primary" data-title="Renouveller?" href=<?php echo "\"renewCert.php?sId=".htmlspecialchars($ok['vente_id'])."\"" ?>><i class="fa fa-fw fa-refresh"></i></a>
                                                                    <a title="Ajouter un véhicule à la flotte" class="toFleet btn btn-mutedr" data-title="Ajouter à la flotte?" href=<?php echo "\"fleet.php?sId=".htmlspecialchars($ok['vente_id'])."\"" ?>><i class="fa fa-fw fa-th"></i></a>
                                                                </td>
                                                            </tr>                             
                                                        <?php
                                                            }
                                                        ?>                                                     
                                                </tbody>
                                            </table>                                             
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
                                <!-- Datatables JavaScript -->
                                <script type="text/javascript" src="js/datatables.min.js"></script>
                                <!-- jquery Confirm -->
                                <script type="text/javascript" src="js/jquery-confirm.js"></script>
                                <!-- Include SmartWizard JavaScript source -->
                                <script type="text/javascript" src="dist/js/jquery.smartWizard.min.js"></script>

                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        // Step show event
                                        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                                        //alert("You are on step "+stepNumber+" now");
                                        if(stepPosition === 'first'){
                                            $("#prev-btn").addClass('disabled');
                                        }else if(stepPosition === 'final'){
                                            $("#next-btn").addClass('disabled');
                                        }else{
                                            $("#prev-btn").removeClass('disabled');
                                            $("#next-btn").removeClass('disabled');
                                        }
                                        });

                                        // Toolbar extra buttons
                                        var btnFinish = $('<button></button>').text('Terminer')
                                                                        .addClass('btn btn-info')
                                                                        .on('click', function(){ alert('Finish Clicked'); });
                                        var btnCancel = $('<button></button>').text('Annuler')
                                                                        .addClass('btn btn-danger')
                                                                        .on('click', function(){ $('#smartwizard').smartWizard("reset"); });

                                        // Smart Wizard 1
                                        $('#smartwizard').smartWizard({
                                                selected: 0,
                                                theme: 'arrows',
                                                transitionEffect:'fade',
                                                showStepURLhash: false,
                                                toolbarSettings: {toolbarPosition: 'bottom',
                                                                toolbarExtraButtons: [btnFinish, btnCancel]
                                                                },
                                                lang: {
                                                next: "Suivant",
                                                previous: "Précédent",
                                                finish: "Terminer"
                                                }
                                        });

                                    });
                                </script>
                                <!-- JQuery Confirm-->
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
                                <!-- DataTable --> 
                                <script>
                                    $(document).ready(function(){
                                        $('#viewTable').DataTable({
                                            language: {
                                                processing:     "Traitement en cours...",
                                                search:         "Filtrerr&nbsp;:",
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
                                <!-- Informations Tooltip -->
                                <script>
                                    $(document).ready(function(){
                                        $('[data-toggle="tooltip"]').tooltip(); 
                                    });
                                </script>

                                <!-- Messages d'informations pour les champs -->   

                                <!-- Puissance Fiscale -->
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#pf').change(function(){
                                            var pf = $(this).val();
                                            var type = 'puissance-fiscale';
                                            $.ajax({
                                                url : "inc/fetch_datas.php",
                                                method : "POST",
                                                data : {pfType:pf,type:type},
                                                dataType : "text",
                                                success : function(data){
                                                    $('#pfValue').html(data);
                                                }
                                            });
                                        });
                                    });
                                </script>

                                <!-- Statut socio-professionnel -->
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#status-pro').change(function(){
                                            var spro = $(this).val();
                                            var type = 'socio-pro';
                                            $.ajax({
                                                url : "inc/fetch_datas.php",
                                                method : "POST",
                                                data : {stat:spro,type:type},
                                                dataType : "text",
                                                success : function(data){
                                                    $('#info-status-pro').prop('title',data);
                                                }
                                            });
                                        });
                                    });
                                </script> 

                                <!-- Catégorie -->                    
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#catcar').change(function(){
                                            var catcar = $(this).val();
                                            var type = 'cat';
                                            $.ajax({
                                                url : "inc/fetch_datas.php",
                                                method : "POST",
                                                data : {cat:catcar,type:type},
                                                dataType : "text",
                                                success : function(data){
                                                    $('#cat-desc').html(data);
                                                }
                                            });
                                        });
                                    });
                                </script> 

                                <!-- Classe du permis de conduire -->
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#classe-permis').change(function(){
                                            var classe = $(this).val();
                                            var type = 'cls-pc';
                                            $.ajax({
                                                url : "inc/fetch_datas.php",
                                                method : "POST",
                                                data : {classe:classe,type:type},
                                                dataType : "text",
                                                success : function(data){
                                                    $('#classe-desc').html(data);
                                                }
                                            });
                                        });
                                    });
                                </script>                                
    </body>     
</html>
