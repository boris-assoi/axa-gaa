<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_sales)) {
        header("location: accesDenied.php");
    }

    include_once "inc/connection.php";
    include_once "inc/models.php";

    //recupération de la vente
    $venteId = $_GET['sId'];

    //Date d'annulation
    $date = date('Y/m/d');

    //Récupération des informations de la vente
    $req  = $bdd->prepare($models['sale_details']);
    $req -> execute(array($_SESSION['userID'], $venteId));
    $ok = $req->fetch();

    //Annulation des attestations
    $req3 = $bdd->prepare($models['cert_to_cancel_sale']);
    $req3->execute(array($venteId, $_SESSION['userID']));
    while ($ok3 = $req3->fetch()) {
        $desc = "Annulation par ".$_SESSION['userPrenom']." ".$_SESSION['userNom']." après la résiliation d'une vente.";
        $req3 = $bdd->prepare($models['cancel_cert']);
        $req3->execute(array($desc, $ok3['attestation_num']));
        $req3->closeCursor();
    }

    $req2  = $bdd->prepare($models['check_fleet_police']);
    $req2 -> execute(array($ok['police_num']));
    $ok2 = $req2->fetch();

    if ($ok2['nbre'] == 1) {
        //Suppression de la vente
        $req = $bdd->prepare($models['cancel_sale']);
        $req->execute(array($ok['vehicule_id']));
        $req->closeCursor();  
    } elseif ($ok2['nbre'] > 1) {
        //Suppression de la flotte
        $req = $bdd->prepare($models['cancel_sale_for_fleet']);
        $req->execute(array($ok['vehicule_id']));
        $req->closeCursor(); 
    }

    header('location: mySales.php');
    
    /*
	$messageType = "commercial";
    $action = "mod";

    header('location: addConfirmed.php?m='.$messageType.'&action='.$action);
    */
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 