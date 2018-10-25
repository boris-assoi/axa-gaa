<?php
try
{
    session_start();
    if (!isset($_SESSION['connect']) OR $_SESSION['connect']!=1) {
        header("location: login.php");
    }
    include_once "../../inc/acl.php";
    include_once "../../inc/connection.php";
    include_once "../../inc/models.php";

    $att = $_GET['att'];
    $vente = $_GET['vid'];
    $pid = $_GET['pid'];
    $date = date('Y-m-d');

    $req = $bdd->prepare($models['cert_sell']);
    $req -> execute(array($vente, $date, $att));

    $request = "SELECT *, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS dateDf, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS dateDt FROM attestation, vehicule, client, police, police_item, vente, categorie_vehicule WHERE attestation_vente = vente_id AND vente_vehicule = vehicule_id AND vehicule_police = police_num AND police_item_police = police_num AND pol_client = client_id AND vehicule_cat = cat_vehicule_id AND attestation_num = ? AND vente_id = ? AND police_item_id = ?";
    $req2 = $bdd->prepare($request);
    $req2->execute(array($att, $vente, $pid));

?> 
<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../../images/logo_32_32.ico" />
<link href="../../css/bootstrap.min.css" rel="stylesheet"> 
</head>

<body style="margin: 0;">

<div id="p1" style="overflow: hidden; position: relative; width: 1286px; height: 709px;">

<!-- Begin shared CSS values -->
<style class="shared-css" type="text/css" >
.t {
	-webkit-transform-origin: top left;
	-moz-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	-webkit-transform: scale(0.25);
	-moz-transform: scale(0.25);
	-o-transform: scale(0.25);
	-ms-transform: scale(0.25);
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >

#t1_1{left:794px;top:361px;letter-spacing:-0.1px;}
#t2_1{left:672px;top:335px;letter-spacing:-0.4px;word-spacing:0.4px;}
#t3_1{left:721px;top:393px;letter-spacing:-0.1px;}
#t4_1{left:865px;top:393px;letter-spacing:-0.1px;}
#t5_1{left:789px;top:414px;letter-spacing:-0.2px;}
#t6_1{left:784px;top:438px;letter-spacing:-0.3px;}
#t7_1{left:730px;top:479px;}
#t8_1{left:672px;top:315px;word-spacing:-0.3px;}
#t9_1{left:465px;top:370px;letter-spacing:-0.1px;}
#ta_1{left:400px;top:398px;letter-spacing:-0.1px;}
#tb_1{left:530px;top:398px;}
#tc_1{left:487px;top:420px;letter-spacing:-0.1px;}
#td_1{left:465px;top:439px;letter-spacing:-0.3px;}
#te_1{left:430px;top:488px;}
#tf_1{left:136px;top:370px;letter-spacing:-0.1px;}
#tg_1{left:80px;top:334px;letter-spacing:-0.4px;word-spacing:0.4px;}
#th_1{left:100px;top:396px;letter-spacing:-0.1px;}
#ti_1{left:205px;top:396px;letter-spacing:-0.1px;}
#tj_1{left:173px;top:418px;letter-spacing:-0.2px;}
#tk_1{left:140px;top:439px;letter-spacing:-0.4px;}
#tl_1{left:80px;top:490px;}
#tm_1{left:80px;top:317px;}

.s1_1{
	FONT-SIZE: 66.1px;
	FONT-FAMILY: "Arial Bold";
	font-weight: bold;
	color: rgb(0,0,0);
}

.s2_1{
	FONT-SIZE: 59px;
	FONT-FAMILY: "Arial Bold";
	font-weight: bold;
	color: rgb(0,0,0);
}

</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts1" type="text/css" >

@font-face {
	font-family: Arial-Bold_a;
	src: url("fonts/Arial-Bold_a.woff") format("woff");
}

</style>
<!-- End embedded font definitions -->

<!-- Begin page background -->
<a href="JavaScript:window.print()" class="hidden-print">
	<button type="button" class="btn hidden-print">Imprimer</button>
</a>
<a href="JavaScript:window.history.back()" class="hidden-print">
    <button type="button" class="btn btn-info"><i class="fa fa-fw fa-arrow-left"></i> Retour</button>
</a>
<div id="pg1Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg1" style="-webkit-user-select: none;"><object width="1286" height="489" data="1/1.svg" type="image/svg+xml" id="pdf1" style="width:1286px; height:489px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->


<!-- Begin text definitions (Positioned/styled in CSS) -->
<?php 
	while ($ok = $req2->fetch())
	{
 ?>
<div id="t1_1" class="t s1_1"><?php echo htmlspecialchars($ok['police_num']); ?></div>
<div id="t2_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_adresse']); ?></div>
<div id="t3_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="t4_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="t5_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_genre']); ?></div>
<div id="t6_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></div>
<div id="t7_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_mat']); ?></div>
<div id="t8_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_nom']); ?></div>
<div id="t9_1" class="t s1_1"><?php echo htmlspecialchars($ok['police_num']); ?></div>
<div id="ta_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="tb_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="tc_1" class="t s2_1"><?php echo htmlspecialchars($ok['vehicule_genre']); ?></div>
<div id="td_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></div>
<div id="te_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_mat']); ?></div>
<div id="tf_1" class="t s1_1"><?php echo htmlspecialchars($ok['police_num']); ?></div>
<div id="tg_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_adresse']); ?></div>
<div id="th_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="ti_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="tj_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_genre']); ?></div>
<div id="tk_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></div>
<div id="tl_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_mat']); ?></div>
<div id="tm_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_nom']); ?></div>
<?php 
	}
 ?>

<!-- End text definitions -->


</div>
<?php
    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?>
<!-- jQuery -->                                 
<script src="../../js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->                                 
<script src="../../js/bootstrap.min.js"></script>
</body>
</html>
