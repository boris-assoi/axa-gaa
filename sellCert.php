<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: login.php");
    }
    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_sales)) {
        header("location: accesDenied.php");
    }

    include_once "inc/connection.php";
    include_once "inc/models.php";
    include_once "inc/utilities.php";
?> 
    <!DOCTYPE html> 
    <html lang="en"> 
        <head> 
            <meta charset="utf-8"> 
            <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
            <meta name="viewport" content="width=device-width, initial-scale=1"> 
            <meta name="description" content=""> 
            <meta name="author" content=""> 
            <title>AXA LG2A</title>             
            <!-- Bootstrap Core CSS -->             
            <link rel="stylesheet" type="text/css" href="css/style2.css" /> 
            <link href="css/bootstrap.min.css" rel="stylesheet"> 
            <!-- Custom CSS -->             
            <link href="css/sb-admin.css" rel="stylesheet"> 
            <link href="css/jquery-confirm.css" rel="stylesheet"> 
            <!-- Custom Fonts -->             
            <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
            <!-- Fichiers CSS pour le wizard form -->
            <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
            <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
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
                                <h1 class="page-header"> <span>Faire une vente</span> </h1> 
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
                                            <form method="POST" id="signup-form" class="signup-form" action="inc/cat1_waranties.php">
                                                <div>
                                                    <h3>SOUSCRIPTEUR</h3>
                                                    <fieldset>
                                                        <h2>Identification du souscripteur</h2>
                                                        <p class="desc">Entrez les informations du souscripteur s'il vous plait</p>
                                                        <div class="fieldset-content">
                                                            <div class="form-group">
                                                                <label class="form-label">Attestation</label>
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
                                                                <span class="text-input">
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
                                                                </span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Client</label>
                                                                <select class="form-control text-uppercase" name="type"> 
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
                                                                <span class="text-input">Type de client</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" name="nom" id="last_name"/>
                                                                <span class="text-input">Nom du client</span>
                                                            </div>                                                           
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="text" name="pro" id="email" />
                                                                        <span class="text-input">Profession</span></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="phone" id="phone" />
                                                                        <span class="text-input">Téléphone</span></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="adresse" id="phone" />
                                                                        <span class="text-input">Adresse</span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
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
                                                                        <span class="text-input">Classe d'ancienneté</span>
                                                                    </div>
                                                                    <div class="form-group">
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
                                                                        <span class="text-input">Statut socio-professionnel</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Police</label>
                                                                <input type="text" name="pol" maxlength="10" placeholder="Entrer le numéro de la police"> 
                                                                <span class="text-input">Numéro de police</span></span>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="date" name="poldf"/>
                                                                        <span class="text-input">Date d'effet de la police</span></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="date" name="poldt"/>
                                                                        <span class="text-input">Date d'échéance de la police</span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <h3>VEHICULE</h3>
                                                    <fieldset>
                                                        <h2>Informations du véhicule</h2>
                                                        <p class="desc">Entrez les informations du véhicule s'il vous plait</p>
                                                        <div class="fieldset-content">
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
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
                                                                        <span class="text-input">Catégorie</span>
                                                                    </div>
                                                                    <div class="form-group">
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
                                                                        <span class="text-input">Genre</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="date" name="dateCirculation" id="dateCirculation">
                                                                        <span class="text-input">Date de mise en circulation</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="carMake">
                                                                        <span class="text-input">Marque</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="imat">
                                                                        <span class="text-input">Numéro d'immatriculation</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="chassis">
                                                                        <span class="text-input">Numéro de chassis</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <select id="pf" class="form-control" name="pf">
                                                                            <option>Sélectionner le type de puissance fiscale</option>
                                                                            <option>Essence</option>                                                         
                                                                            <option>Diesel</option>                                                         
                                                                        </select>
                                                                        <span class="text-input">Type de puissance fiscale</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select id="pfValue" class="form-control" name="pfValue"> 
                                                                            <option>Sélectionnez</option>
                                                                        </select>
                                                                        <span class="text-input">Puissance fiscale</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="text" name="valCat" id="val-cat">
                                                                        <span class="text-input">Valeur catalogue</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="valVen" id="val-ven" disabled="disabled">
                                                                        <span class="text-input">Valeur vénale</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <h3>FORMULE</h3>
                                                    <fieldset>
                                                        <h2>Formule des garanties</h2>
                                                        <p class="desc">Choisissez la garantie en fonction des garanties associées</p>
                                                        <div class="fieldset-content">
                                                            <div class="form-row">
                                                                <div class="form-flex">
                                                                    <div class="middle">
                                                                        <label>
                                                                            <input type="radio" name="radio" checked/>
                                                                            <div class="front-end box">
                                                                                <span>Front-end</span>
                                                                            </div>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="radio"/>
                                                                            <div class="back-end box">
                                                                                <span>Back-end</span>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    
                                                </div>
                                            </form>
                                            <div class="text-right"></div>                                              
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
                    <script src="js/jquery-confirm.js"></script>
                    <script src="js/form-ajax.js"></script>
                    <!--Fichiers JavaScript pour le wizard form -->
                    <script src="vendor/jquery/jquery.min.js"></script>
                    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
                    <script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
                    <script src="vendor/jquery-steps/jquery.steps.min.js"></script>
                    <script src="vendor/nouislider/nouislider.min.js"></script>
                    <script src="vendor/wnumb/wNumb.js"></script>
                    <script src="js/main.js"></script>                
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
                    <script>
                        $(document).ready(function(){
                            $('[data-toggle="tooltip"]').tooltip(); 
                        });
                    </script>                                     
        </body>         
    </html>
