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
                                                        <div class="form-group"> 
                                                            <label class="control-label">Le véhicule possède-t-il une remorque? </label> 
                                                            <input type="checkbox" value="rem" id="rem" name="rem">                                             
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <legend><input type="checkbox" value="rem" id="def-rec"> Garantie défense et recours</legend>
                                                        <div class="form-group form-inline"> 
                                                                <select class="form-control text-uppercase" name="defense" id="defense" enable="false">
                                                                <option>Sélectionnez le type de garantie</option>
                                                                <?php
                                                                $request='SELECT lib FROM type_g_def_rec';
                                                                $req = $bdd->query($request);
                                                                while ($ok = $req->fetch())
                                                                {
                                                                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                                                                }
                                                                $req->closeCursor();                        
                                                            ?>
                                                        </div>
                                                    </fieldset>                                       
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
                    <script>
                        $(document).ready(function(){
                            $('[data-toggle="tooltip"]').tooltip(); 
                        });
                    </script>                    
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
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#def-rec').change(function(){
                                $('#defense').prop('enabled','enabled');
                            })
                        })
                    </script>                  
        </body>         
    </html>
