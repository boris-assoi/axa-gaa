 
<!-- Navigation --> 
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation"> 
    <!-- Brand and toggle get grouped for better mobile display -->     
    <div class="navbar-header"> 
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 
            <span class="sr-only">Toggle navigation</span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
        </button>         
        <a class="navbar-brand" href="index.php">AXA LG2A</a> 
    </div>     
    <!-- Top Menu Items -->     
    <ul class="nav navbar-right top-nav">         
        <li class="dropdown"> 
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: capitalize"> 
                <i class="fa fa-user"></i> 
                <?php echo $_SESSION['userPrenom']." ".$_SESSION['userNom']; ?> 
                <b class="caret"></b> 
            </a>             
            <ul class="dropdown-menu">
                <li>
                    <a href="settings.php"><i class="fa fa-fw fa-cog"></i> Paramètres</a> 
                </li>
                <li class="separator"></li>
                <li> 
                    <a href="signout.php"><i class="fa fa-fw fa-power-off"></i> Deconnexion</a> 
                </li>                 
            </ul>             
        </li>         
    </ul>     
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->     
    <div class="collapse navbar-collapse navbar-ex1-collapse"> 
        <ul class="nav navbar-nav side-nav"> 
            <li class="active"> 
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Accueil</a> 
            </li>
                <?php 
                    if (in_array($_SESSION['type'], $acl_manage_store)) {
                ?>
                    <li>
                        <a href="listBatch.php"><i class="fa fa-fw fa-sign-in"></i> Commande</a>
                    </li>
                <?php
                    } 
                    if (in_array($_SESSION['type'], $acl_manage_certs)) {
                ?>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#attestation"><i class="fa fa-fw fa-file"></i> Attestation <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="attestation" class="collapse">
                            <?php
                                if (in_array($_SESSION['type'], $acl_manage_certs)) {
                            ?> 
                            <li>
                                <a href="listCertificate.php">Consulter les attestations</a>
                            </li>                     
                            <?php
                                } 
                                if (in_array($_SESSION['type'], $acl_attrib_cert)) {
                            ?> 
                            <li>
                                <a href="attrCertificate.php">Attribuer une attestation</a>
                            </li>                     
                            <?php
                                }
                                if (in_array($_SESSION['type'], $acl_sales)) {
                            ?> 
                            <li>
                                <a href="listClients.php">Liste des clients</a>
                            </li>
                            <?php
                                }
                                if (in_array($_SESSION['type'], $acl_sales)) {
                            ?> 
                            <li>
                                <a href="mySales.php">Ventes</a>
                            </li>
                            <?php
                                }
                                if (in_array($_SESSION['type'], $acl_cert_annul)) {
                            ?> 
                            <li>
                                <a href="listCanceled.php">Consulter les annulations</a>
                            </li>
                            <?php
                                }
                            ?> 
                        </ul>
                    </li>
                <?php
                    }
                    
                    if (in_array($_SESSION['type'], $acl_manage_centers)) {
                ?>  
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#center"><i class="fa fa-fw fa-home"></i> Centre <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="center" class="collapse">
                            <?php 
                                if (in_array($_SESSION['type'], $acl_manage_centers)) {
                            ?>
                            <li>
                                <a href="newPos.php">Création d'un point de vente</a>
                            </li>                     
                            <?php
                                } 
                                if (in_array($_SESSION['type'], $acl_manage_centers)) {
                            ?> 
                            <li>
                                <a href="newUg.php">Création d'une unité de gestion</a>
                            </li>                    
                            <?php
                                }
                            ?> 
                        </ul>
                    </li>         
                    <li class="divider"></li>                     
                <?php
                     }
                    if (in_array($_SESSION['type'], $acl_manage_users)) {
                ?>  
                    <li>
                        <a href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</i></a>
                    </li>        
                    <li class="divider"></li>                     
                <?php
                     }
                     if (in_array($_SESSION['type'], $acl_reports)) {
                ?>  
                    <li>
                        <a href="reportSales.php"><i class="fa fa-fw fa-bar-chart"></i> Rapports</i></a>
                    </li>        
                    <li class="divider"></li>                     
                <?php
                     }
                ?>
        </ul>         
    </div>     
    <!-- /.navbar-collapse -->     
</nav>