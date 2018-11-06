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
                                            <div class="panel-heading"> 
</div>                                             
                                            <div class="panel-body"> 
                                                <form role="form" method="POST" action="inc/cat1_waranties.php"> 
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
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Date d'obtention du permis</label>                                                         
                                                        <select id="" class="form-control text-uppercase" name="cls_pc"> 
                                                            <?php
                                                            $request='SELECT lib FROM classe_permis';
                                                            $req = $bdd->query($request);
                                                            while ($ok = $req->fetch())
                                                            {
                                                                echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                                                            }
                                                            $req->closeCursor();                        
                                                        ?> 
                                                    </div>
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Statut socio-professionnel</label>                                                         
                                                        <select id="formInput28" class="form-control text-uppercase" name="carGenre"> 
                                                            <?php
                                                            $request='SELECT lib, info FROM statut_socio_pro';
                                                            $req = $bdd->query($request);
                                                            while ($ok = $req->fetch())
                                                            {
                                                                echo "<option class=\"\">".htmlspecialchars($ok['lib'])." - ".htmlspecialchars($ok['info'])."</option>";
                                                            }
                                                            $req->closeCursor();                        
                                                        ?> 
                                                        </select>                                                         
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Profession</label>                                                         
                                                        <input type="text" class="form-control" placeholder="Profession du client" name="pro"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Adresse</label>                                                         
                                                        <input type="text" class="form-control" name="adresse" placeholder="Adresse du client"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Contact</label>                                                         
                                                        <input type="text" class="form-control" name="contact" placeholder="Contact du client"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Police N°</label>                                                         
                                                        <input type="text" class="form-control" name="pol" maxlength="10" placeholder="Entrer le numéro de la police"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Date de début de la police</label>                                                         
                                                        <input type="date" class="form-control" placeholder="Entrer la date de début de la police" name="poldf"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Date de fin de la police</label>                                                         
                                                        <input type="date" class="form-control" placeholder="Entrer la date de fin de la police" name="poldt"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Genre du véhicule</label>                                                         
                                                        <select id="formInput28" class="form-control" name="carGenre"> 
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
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Marque du véhicule</label>                                                         
                                                        <input type="text" class="form-control" placeholder="Entrer la marque du véhicule" name="carMake"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Immatriculation du véhicule</label>                                                         
                                                        <input type="text" class="form-control" name="imat" placeholder="Entrer le numéro d'immatriculation du véhicule"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="exampleInputPassword1">Numéro de chassis</label>                                                         
                                                        <input type="text" class="form-control" name="chassis" placeholder="Entrer le numéro de chassis du véhicule"> 
                                                    </div>                                                     
                                                    <div class="form-group"> 
                                                        <label class="control-label" for="formInput28">Catégorie du véhicule</label>                                                         
                                                        <select id="formInput28" class="form-control" name="cat"> 
                                                            <?php
                                                            $request='SELECT cat_vehicule_id FROM categorie_vehicule';
                                                            $req = $bdd->query($request);
                                                            while ($ok = $req->fetch())
                                                            {
                                                                echo "<option class=\"\"> Catégorie ".htmlspecialchars($ok['cat_vehicule_id'])."</option>";    
                                                            }
                                                            $req->closeCursor();                        
                                                        ?> 
                                                        </select>                                                         
                                                    </div>                                                     
                                                    <div class="form-group form-inline"> 
                                                        <label class="control-label" for="exampleInputPassword1">Puissance fiscale</label>
                                                    </br>                                                     
                                                    <select id="pf" class="form-control" name="pf">
                                                        <option>Sélectionner le type de puissance fiscale</option>
                                                        <option>Essence</option>                                                         
                                                        <option>Diesel</option>                                                         
                                                    </select>
                                                    <select id="pfValue" class="form-control" name="pfValue"> 
                                                        <option>Sélectionnez la puissance fiscale</option>
                                                    </select>
                                            </div>
                                            <div class="checkbox"> 
                                                <label class="control-label"> 
                                                    <input type="checkbox" value="rem" id="rem" name="remorque">       Remorque        
                                                </label>                                                 
                                            </div>                                             
                                        </div>                                         
                                        <div class="form-group"> 
                                            <label class="control-label" for="exampleInputPassword1">Montant de la police</label>                                             
                                            <input type="number" class="form-control" name="amount" placeholder="Entrer le montant"> 
                                        </div>                                         
                                        <input type="text" hidden="" value="1" name="vType"> 
                                        <button type="submit" class="btn btn-success">Vendre</button>                                         
                                        <a href="JavaScript:window.history.back()" class="hidden-print"> 
                                            <button type="button" class="btn btn-danger">Annuler</button>                                             
                                        </a>                                         
                                    </form>                                     
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
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#pf').change(function(){
                                var pf = $(this).val();
                                $.ajax({
                                    url : "inc/fetch_pfvalue.php",
                                    method : "POST",
                                    data : {pfType:pf},
                                    dataType : "text",
                                    success : function(data){
                                        $('#pfValue').html(data);
                                    }

                                });
                            });
                        });
                    </script>                  
        </body>         
    </html>
