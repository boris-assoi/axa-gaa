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
    $venteId = $_POST['vente_id'];
    $client = $_POST['nom'];

    $req  = $bdd->prepare($models['sale_details_for_pos_operation']);
    $req -> execute(array($_SESSION['userID'], $venteId));
    $ok = $req->fetch();

    //recupération des informations de la police
    $pol = $ok['police_num'];

    //Recupération du montant de la vente pour le renouvellement
    $amount = $_POST['amount'];
    $vType = $_POST['vType'];

    /*
    //Informations sur le client
    $nom = $_POST['nom'];
    $profession = $_POST['pro'];
    $adresse = $_POST['adresse'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];

    //Informations sur la police
    $pol = $_POST['pol'];
    $poldf = $_POST['poldf'];
    $poldt = $_POST['poldt'];
    */
    //Information sur le véhicule
    $carGenre = $_POST['carGenre'];
    $carMake = $_POST['carMake'];
    $imat = $_POST['imat'];
    $chassis = $_POST['chassis'];
    $cat = $_POST['cat'];

    //Enregistrement du vehicule
    $cat = trim(substr($cat,strrpos(trim($cat),' ')));
    $date = date('Y-m-d');
    $req = $bdd->prepare($models['cert_new_vehicule']);
    $req->execute(array($imat, $chassis, $carMake, $carGenre, $cat, $pol));
    $req->closeCursor();

    //Enregistrement de la vente
    $req = $bdd->prepare($models['cert_new_fleet_vente']);
    $req->execute(array($amount, $ok['police_num'], $_SESSION['userID'], $vType, $ok['vente_type_attestation']));
    $req->closeCursor();
    
    //Enregistrement de l'item de police
    $req  =  $bdd->prepare($models['cert_new_police_item']);
    $req->execute(array($ok['pol_date_deb'], $ok['pol_date_fin'], $ok['police_num'], $_SESSION['userID']));
    $req->closeCursor();

    header('location: fleet.php?sId='.$venteId);
    
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