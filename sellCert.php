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
            <link href="css/style.css" rel="stylesheet">
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
                                            <div class="panel-heading"></div>                                             
                                            <div class="panel-body"> 
                                                <!--Formulaire-->
                                                <form action="" id="wizard">
                                                    <!-- SECTION 1 -->
                                                    <h4></h4>
                                                    <section>
                                                        <h3>Basic details</h3>
                                                        <div class="form-row">
                                                            <div class="form-holder">
                                                                <i class="zmdi zmdi-account"></i>
                                                                <input type="text" class="form-control" placeholder="First Name">
                                                            </div>
                                                            <div class="form-holder">
                                                                <i class="zmdi zmdi-account"></i>
                                                                <input type="text" class="form-control" placeholder="Last Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-holder">
                                                                <i class="zmdi zmdi-email"></i>
                                                                <input type="text" class="form-control" placeholder="Email ID">
                                                            </div>
                                                            <div class="form-holder">
                                                                <i class="zmdi zmdi-account-box-o"></i>
                                                                <input type="text" class="form-control" placeholder="Your User ID">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-holder">
                                                                <i class="zmdi zmdi-map"></i>
                                                                <input type="text" class="form-control" placeholder="Country">
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-holder">
                                                                    <i class="zmdi zmdi-pin"></i>
                                                                    <input type="text" class="form-control" placeholder="State">
                                                                </div>
                                                                <div class="form-holder">
                                                                    <i class="zmdi zmdi-pin-drop"></i>
                                                                    <input type="text" class="form-control" placeholder="City">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-holder">
                                                                <i class="zmdi zmdi-smartphone-android"></i>
                                                                <input type="text" class="form-control" placeholder="Phone Number">
                                                            </div>
                                                            <div class="form-holder password">
                                                                <i class="zmdi zmdi-eye"></i>
                                                                <input type="password" class="form-control" placeholder="Reference Coder">
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <!-- SECTION 2 -->
                                                    <h4></h4>
                                                    <section>
                                                        <h3>Password change</h3>
                                                        <div class="form-row">
                                                            <div class="form-holder w-100">
                                                                <input type="password" class="form-control" placeholder="Current Password">
                                                                <i class="zmdi zmdi-lock-open"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-holder w-100">
                                                                <input type="password" class="form-control" placeholder="Enter the Current Password">
                                                                <i class="zmdi zmdi-lock-open"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-holder w-100">
                                                                <input type="password" class="form-control" placeholder="New Password">
                                                                <i class="zmdi zmdi-lock-open"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-holder w-100">
                                                                <input type="password" class="form-control" placeholder="Confirm New Password">
                                                                <i class="zmdi zmdi-lock-open"></i>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <!-- SECTION 3 -->
                                                    <h4></h4>
                                                    <section>
                                                        <h3 style="margin-bottom: 16px;">My Cart</h3>
                                                        <table cellspacing="0" class="table-cart shop_table shop_table_responsive cart woocommerce-cart-form__contents table" id="shop_table">
                                                            <thead>
                                                                <th >&nbsp;</th>
                                                                <th style="text-align: left;">Product Detail</th>
                                                                <th >Quantity</th>
                                                                <th >Total Price</th>
                                                                <th >&nbsp;</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="product-thumb">
                                                                        <a href="#" class="item-thumb">
                                                                            <img src="images/item-1.jpg" alt="">
                                                                        </a>
                                                                    </td>
                                                                    <td class="product-detail" data-title="Product Detail">
                                                                        <div>
                                                                            <a href="#">Cherry</a>
                                                                            <span>$</span>
                                                                            <span>35</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="product-quantity" data-title="Quantity">
                                                                        <div class="quantity">
                                                                            <span class="plus">+</span>
                                                                            <input type="number" id="quantity_5b4f198d958e1" class="input-text qty text" step="1" min="0" max="" name="cart[5934c1ec0cd31e12bd9084d106bc2e32][qty]" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" />
                                                                            <span class="minus">-</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="total-price" data-title="Total Price">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <span class="woocommerce-Price-currencySymbol">$</span>
                                                                            70
                                                                        </span>
                                                                    </td>
                                                                    <td class="product-remove">
                                                                        <a href="#">
                                                                            <i class="zmdi zmdi-close-circle-o"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="product-thumb">
                                                                        <a href="#" class="item-thumb">
                                                                            <img src="images/item-2.jpg" alt="">
                                                                        </a>
                                                                    </td>
                                                                    <td class="product-detail" data-title="Product Detail">
                                                                        <div>
                                                                            <a href="#">Mango</a>
                                                                            <span>$</span>
                                                                            <span>2035</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="product-quantity" data-title="Quantity">
                                                                        <div class="quantity">
                                                                            <span class="plus">+</span>
                                                                            <input type="number" id="quantity_5b4f198d958e1" class="input-text qty text" step="1" min="0" max="" name="cart[5934c1ec0cd31e12bd9084d106bc2e32][qty]" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" />
                                                                            <span class="minus">-</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="total-price" data-title="Total Price">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <span class="woocommerce-Price-currencySymbol">$</span>
                                                                            20
                                                                        </span>
                                                                    </td>
                                                                    <td class="product-remove">
                                                                        <a href="#">
                                                                            <i class="zmdi zmdi-close-circle-o"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </section>

                                                    <!-- SECTION 4 -->
                                                    <h4></h4>
                                                    <section>
                                                        <h3>Cart Totals</h3>
                                                        <div class="cart_totals">
                                                            <table cellspacing="0" class="shop_table shop_table_responsive">
                                                                <tr class="cart-subtotal">
                                                                    <th>Subtotal</th>
                                                                    <td data-title="Subtotal">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <span class="woocommerce-Price-currencySymbol">$</span>110.00
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="cart-subtotal shipping">
                                                                    <th>Shipping:</th>
                                                                    <td data-title="Subtotal">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="radio" name="shipping" checked> Free Shipping
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="shipping"> Local pickup: <span>$</span><span>0.00</span>
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <span>Calculate shipping</span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="cart-subtotal">
                                                                    <th>Service <span>(estimated for Vietnam)</span></th>
                                                                    <td data-title="Subtotal">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <span class="woocommerce-Price-currencySymbol">$</span>5.60
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="order-total border-0">
                                                                    <th>Total</th>
                                                                    <td data-title="Total">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <span class="woocommerce-Price-currencySymbol">$</span>64.69
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        
                                                    </section>
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
                    <script src="js/jquery-3.3.1.min.js"></script>                     
                    <!-- Bootstrap Core JavaScript -->                     
                    <script src="js/bootstrap.min.js"></script>                     
                    <script src="js/jquery-confirm.js"></script> 
                    <script src="js/ajax-form.js"></script>
                    <script src="js/jquery.steps.js"></script>
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
        </body>         
    </html>
