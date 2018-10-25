<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: login.php");
    }
    include_once "inc/acl.php";
    
    if (!in_array($_SESSION['type'], $acl_attrib_cert)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/models.php";
    include_once "inc/connection.php";
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
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="images/logo_32_32.ico" /> 
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
                            <h1 class="page-header"> <span>Attribuer des attestations</span> </h1> 
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
                                            <form role="form" method="POST" class="myForm" action="attrConfirm.php">
                                                <div class="form-group"> 
                                                    <label class="control-label" for="formInput28">Sélectionner le type d'attestation</label>
                                                    <select id="typAtt" class="form-control" name="typAtt" required="required"> 
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
                                                    <label class="control-label" for="formInput28">Attribuer à</label>
                                                    <select id="formInput28" class="form-control" name="to" required="required"> 
                                                        <?php
                                                            $req = $bdd->prepare($models['attib_to']);
                                                            $req->execute(array($_SESSION['userID']));
                                                            while ($ok = $req->fetch())
                                                            {
                                                                echo "<option>".htmlspecialchars($ok['c_nom'])."</option>";    
                                                            }
                                                            $req->closeCursor();                        
                                                        ?>                                                         
                                                    </select>
                                                </div>                                                 
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">Numéro d'attestation de début</label>                                                     
                                                    <input type="number" class="form-control" placeholder="Entrer le numéro de la 1ère attestation à attribuer" name="nAtt" required="required"> 
                                                </div>                                                 
                                                <div class="form-group"> 
                                                    <label class="control-label" for="exampleInputPassword1">
                                                        <span class="text-uppercase">
                                                            <span> Disponibilité - </span>
                                                            <?php
                                                                $req  = $bdd->prepare($models['dispoAuto']);
                                                                $req -> execute(array($_SESSION['userID']));
                                                                $ok = $req->fetch();
                                                                echo "Automobile : <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
                                                                $req->closeCursor();
                                                                
                                                            ?>
                                                            <?php
                                                                $req  = $bdd->prepare($models['dispoBrune']);
                                                                $req -> execute(array($_SESSION['userID']));
                                                                $ok = $req->fetch();
                                                                echo "Brune CEDEAO: <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
                                                                $req->closeCursor();
                                                                
                                                            ?>
                                                            <?php
                                                                $req  = $bdd->prepare($models['dispoVerte']);
                                                                $req -> execute(array($_SESSION['userID']));
                                                                $ok = $req->fetch();
                                                                echo "Carte Verte : <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
                                                                $req->closeCursor();
                                                                
                                                            ?>
                                                        </span> 
                                                    </label>                                                     
                                                    <input type="number" class="form-control" placeholder="Entrer le nombre à attribuer" name="nbAtt" required="required"> 
                                                </div>                                              
                                                <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#attrib">Attribuer</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="attrib" tabindex="-1" role="dialog" aria-labelledby="attribLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        Veuillez remplir les champs requis s'il vous plait.
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <a href="listCertificate.php" class="hidden-print">
                                                    <button type="button" class="btn btn-danger">Annuler</button>
                                                </a>                                                 
                                            </form>                                             
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
                                <!--
                                <script type="text/javascript">
                                    $(function() {
                                      $('.myForm').submit(function(event) {
                                        event.preventDefault();
                                        var form = $(this)[0];

                                        $.confirm({
                                          columnClass: 'col-md-4 col-md-offset-4',
                                          theme: 'material',
                                          animation: 'scaleY',
                                          title: 'Confirmer',
                                          content: 'Vous allez faire une attribution de carte <b>'+document.getElementById('typAtt').value+'</b> allant de <b>'+document.getElementById('nAtt').value+'</b> à <b>'+(parseInt(document.getElementById('nAtt').value,10) + parseInt(document.getElementById('nbAtt').value, 10) - 1) +'</b>',
                                          confirmButton: 'Oui',
                                          cancelButton: 'Non',
                                          confirmButtonClass: 'btn-success',
                                          cancelButtonClass: 'btn-danger',
                                          confirm: function() {
                                            //Submit the form
                                                form.submit
                                            });
                                          },
                                          cancel: function() {
                                            //Do nothing
                                          }
                                        });
                                      });
                                    });
                                </script>  
                                -->                               
    </body>     
</html>
