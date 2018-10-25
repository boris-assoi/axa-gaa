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

    $req  = $bdd->prepare($models['sale_details_for_pos_operation']);
    $req -> execute(array($_SESSION['userID'], $venteId));
    $ok = $req->fetch();

    //recupération des informations de la nouvelle police
    $poldf = $_POST['poldf'];
    $poldt = $_POST['poldt'];
    $vType = $_POST['vType'];

    //Recupération du montant de la vente pour le renouvellement
    $amount = $_POST['amount'];

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

    //Information sur le véhicule
    $carGenre = $_POST['carGenre'];
    $carMake = $_POST['carMake'];
    $imat = $_POST['imat'];
    $chassis = $_POST['chassis'];
    $cat = $_POST['cat'];
    */

    //Enregistrement de la vente
    $req = $bdd->prepare($models['renew_vente']);
    $req->execute(array($amount, $ok['vehicule_id'], $_SESSION['userID'], $vType, $ok['vente_type_attestation']));
    $req->closeCursor();
    
    //Enregistrement de la police
    $req  =  $bdd->prepare($models['renew_police_item']);
    $req->execute(array($poldf, $poldt, $ok['police_num'], $_SESSION['userID']));
    $req->closeCursor();


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