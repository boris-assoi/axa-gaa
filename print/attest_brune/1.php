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

#t1_1{left:95px;top:311px;letter-spacing:-0.3px;word-spacing:0.4px;}
#t2_1{left:180px;top:355px;letter-spacing:-0.2px;}
#t3_1{left:188px;top:377px;letter-spacing:-0.2px;}
#t4_1{left:185px;top:395px;letter-spacing:-0.1px;word-spacing:0.2px;}
#t5_1{left:107px;top:450px;letter-spacing:-0.2px;word-spacing:0.4px;}
#t6_1{left:691px;top:463px;letter-spacing:-0.3px;word-spacing:0.4px;}
#t7_1{left:171px;top:472px;letter-spacing:-0.2px;}
#t8_1{left:104px;top:494px;letter-spacing:-0.2px;}
#t9_1{left:228px;top:494px;letter-spacing:-0.2px;}
#ta_1{left:175px;top:542px;letter-spacing:-0.4px;}
#tb_1{left:367px;top:311px;letter-spacing:-0.3px;word-spacing:0.4px;}
#tc_1{left:445px;top:355px;letter-spacing:-0.2px;}
#td_1{left:457px;top:377px;letter-spacing:-0.3px;}
#te_1{left:448px;top:395px;word-spacing:-0.6px;}
#tf_1{left:379px;top:450px;letter-spacing:-0.2px;word-spacing:0.4px;}
#tg_1{left:431px;top:472px;letter-spacing:-0.2px;}
#th_1{left:380px;top:498px;letter-spacing:-0.2px;}
#ti_1{left:454px;top:542px;letter-spacing:-0.4px;}
#tj_1{left:657px;top:347px;letter-spacing:-0.3px;word-spacing:0.4px;}
#tk_1{left:713px;top:390px;letter-spacing:-0.2px;}
#tl_1{left:727px;top:533px;letter-spacing:-0.4px;}
#tm_1{left:885px;top:297px;letter-spacing:-0.2px;}
#tn_1{left:1037px;top:297px;letter-spacing:-0.2px;}
#to_1{left:1000px;top:319px;letter-spacing:-0.2px;}
#tp_1{left:943px;top:342px;letter-spacing:-0.1px;}
#tq_1{left:1081px;top:342px;letter-spacing:-0.2px;}
#tr_1{left:917px;top:386px;letter-spacing:-0.2px;}
#ts_1{left:900px;top:450px;letter-spacing:-0.2px;word-spacing:0.4px;}
#tt_1{left:908px;top:472px;letter-spacing:-0.3px;word-spacing:0.4px;}
#tu_1{left:951px;top:420px;letter-spacing:-0.2px;word-spacing:0.5px;}
#tv_1{left:442px;top:122px;word-spacing:0.1px;}
#tw_1{left:510px;top:498px;letter-spacing:-0.2px;}
#tx_1{left:683px;top:441px;letter-spacing:-0.1px;word-spacing:0.2px;}
#ty_1{left:138px;top:333px;letter-spacing:-0.1px;word-spacing:0.2px;}
#tz_1{left:409px;top:333px;letter-spacing:-0.1px;word-spacing:0.2px;}
#t10_1{left:661px;top:379px;letter-spacing:-0.1px;word-spacing:0.2px;}
#t11_1{left:33px;top:837px;letter-spacing:0.2px;word-spacing:0.1px;}
#t12_1{left:1170px;top:837px;letter-spacing:0.1px;word-spacing:0.1px;}

.s1_1{
	FONT-SIZE: 70.1px;
	FONT-FAMILY: "Arial Bold";
	font-weight: bold;
	color: rgb(0,0,0);
}

.s2_1{
	FONT-SIZE: 122.2px;
	FONT-FAMILY: "Arial Bold";
	font-weight: bold;
	color: rgb(69,69,69);
}

.s3_1{
	FONT-SIZE: 67.2px;
	FONT-FAMILY: "Arial Bold";
	font-weight: bold;
	color: rgb(39,39,39);
}

</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts1" type="text/css" >

@font-face {
	font-family: Calibri-Bold_c;
	src: url("fonts/Calibri-Bold_c.woff") format("woff");
}

@font-face {
	font-family: ArialBlack_a;
	src: url("fonts/ArialBlack_a.woff") format("woff");
}

@font-face {
	font-family: Calibri_e;
	src: url("fonts/Calibri_e.woff") format("woff");
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
<div id="pg1Overlay" style="width:100%; height:50%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg1" style="-webkit-user-select: none;"><object width="1286" height="589" data="1/1.svg" type="image/svg+xml" id="pdf1" style="width:1286px; height:509px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->


<!-- Begin text definitions (Positioned/styled in CSS) -->
<?php 
	while ($ok = $req2->fetch())
	{
 ?>
<div id="t1_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_nom']); ?></div>
<div id="t2_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_mat']); ?></div>
<div id="t3_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></div>
<div id="t4_1" class="t s1_1">AXA Côte d'Ivoire</div>
<div id="t5_1" class="t s1_1">Bureau National Ivoirien</div>
<div id="t6_1" class="t s1_1">01 BP 378 ABJ 01</div>
<div id="t7_1" class="t s1_1"><?php echo htmlspecialchars($ok['police_num']); ?></div>
<div id="t8_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="t9_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="ta_1" class="t s1_1"><?php echo htmlspecialchars($ok['cat_vehicule_lib']); ?></div>
<div id="tb_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_nom']); ?></div>
<div id="tc_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_mat']); ?></div>
<div id="td_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></div>
<div id="te_1" class="t s1_1">AXA Côte d'Ivoire</div>
<div id="tf_1" class="t s1_1">Bureau National Ivoirien</div>
<div id="tg_1" class="t s1_1"><?php echo htmlspecialchars($ok['police_num']); ?></div>
<div id="th_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="ti_1" class="t s1_1"><?php echo htmlspecialchars($ok['cat_vehicule_lib']); ?></div>
<div id="tj_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_nom']); ?></div>
<div id="tk_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_mat']); ?></div>
<div id="tl_1" class="t s1_1"><?php echo htmlspecialchars($ok['cat_vehicule_lib']); ?></div>
<div id="tm_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="tn_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="to_1" class="t s1_1"><?php echo htmlspecialchars($ok['police_num']); ?></div>
<div id="tp_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDf']); ?></div>
<div id="tq_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="tr_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_marque']); ?></div>
<div id="ts_1" class="t s1_1">Bureau National Ivoirien</div>
<div id="tt_1" class="t s1_1">01 BP 3878 ABJ 01</div>
<div id="tu_1" class="t s1_1"><?php echo htmlspecialchars($ok['vehicule_chassis']); ?></div>
<div id="tw_1" class="t s1_1"><?php echo htmlspecialchars($ok['dateDt']); ?></div>
<div id="tx_1" class="t s1_1">AXA Côte d'Ivoire</div>
<div id="ty_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_adresse']); ?></div>
<div id="tz_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_adresse']); ?></div>
<div id="t10_1" class="t s1_1"><?php echo htmlspecialchars($ok['client_adresse']); ?></div>
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
</body>
</html>
