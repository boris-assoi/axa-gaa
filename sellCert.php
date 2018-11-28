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
                                                        <p class="desc">Entrer les informations du souscripteur s'il vous plait</p>
                                                        <div class="fieldset-content">
                                                            <div class="form-row">
                                                                <label class="form-label">Nom</label>
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="text" name="first_name" id="first_name" />
                                                                        <span class="text-input">First</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="last_name" id="last_name" />
                                                                        <span class="text-input">Last</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" id="email" />
                                                                <span class="text-input">Example  :<span>  Jeff@gmail.com</span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input type="text" name="phone" id="phone" />
                                                            </div>
                                                            <div class="form-date">
                                                                <label for="birth_date" class="form-label">Birth Date</label>
                                                                <div class="form-date-group">
                                                                    <div class="form-date-item">
                                                                        <select id="birth_month" name="birth_month"></select>
                                                                        <span class="text-input">MM</span>
                                                                    </div>
                                                                    <div class="form-date-item">
                                                                        <select id="birth_date" name="birth_date"></select>
                                                                        <span class="text-input">DD</span>
                                                                    </div>
                                                                    <div class="form-date-item">
                                                                        <select id="birth_year" name="birth_year"></select>
                                                                        <span class="text-input">YYYY</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ssn" class="form-label">SSN</label>
                                                                <input type="text" name="ssn" id="ssn" />
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <h3>VEHICULE</h3>
                                                    <fieldset>
                                                        <h2>Informations du véhicule</h2>
                                                        <p class="desc">Entrez les informations du véhicule s'il vous plait</p>
                                                        <div class="fieldset-content">
                                                            <div class="form-row">
                                                                <label class="form-label">Name</label>
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="text" name="first_name" id="first_name" />
                                                                        <span class="text-input">First</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="last_name" id="last_name" />
                                                                        <span class="text-input">Last</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" id="email" />
                                                                <span class="text-input">Example  :<span>  Jeff@gmail.com</span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input type="text" name="phone" id="phone" />
                                                            </div>
                                                            <div class="form-date">
                                                                <label for="birth_date" class="form-label">Birth Date</label>
                                                                <div class="form-date-group">
                                                                    <div class="form-date-item">
                                                                        <select id="birth_month" name="birth_month"></select>
                                                                        <span class="text-input">MM</span>
                                                                    </div>
                                                                    <div class="form-date-item">
                                                                        <select id="birth_date" name="birth_date"></select>
                                                                        <span class="text-input">DD</span>
                                                                    </div>
                                                                    <div class="form-date-item">
                                                                        <select id="birth_year" name="birth_year"></select>
                                                                        <span class="text-input">YYYY</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ssn" class="form-label">SSN</label>
                                                                <input type="text" name="ssn" id="ssn" />
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <h3>Set Financial Goals</h3>
                                                    <fieldset>
                                                        <h2>Set Financial Goals</h2>
                                                        <p class="desc">Set up your money limit to reach the future plan</p>
                                                        <div class="fieldset-content">
                                                            <div class="form-row">
                                                                <label class="form-label">Name</label>
                                                                <div class="form-flex">
                                                                    <div class="form-group">
                                                                        <input type="text" name="first_name" id="first_name" />
                                                                        <span class="text-input">First</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="last_name" id="last_name" />
                                                                        <span class="text-input">Last</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" id="email" />
                                                                <span class="text-input">Example  :<span>  Jeff@gmail.com</span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input type="text" name="phone" id="phone" />
                                                            </div>
                                                            <div class="form-date">
                                                                <label for="birth_date" class="form-label">Birth Date</label>
                                                                <div class="form-date-group">
                                                                    <div class="form-date-item">
                                                                        <select id="birth_month" name="birth_month"></select>
                                                                        <span class="text-input">MM</span>
                                                                    </div>
                                                                    <div class="form-date-item">
                                                                        <select id="birth_date" name="birth_date"></select>
                                                                        <span class="text-input">DD</span>
                                                                    </div>
                                                                    <div class="form-date-item">
                                                                        <select id="birth_year" name="birth_year"></select>
                                                                        <span class="text-input">YYYY</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ssn" class="form-label">SSN</label>
                                                                <input type="text" name="ssn" id="ssn" />
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
