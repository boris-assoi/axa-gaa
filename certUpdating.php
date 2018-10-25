<?php
try
{
    session_start();

    include_once "inc/acl.php";

    /*
    if (!in_array($_SESSION['type'], $acl_mod_com)) {
        header("location: accesDenied.php");
    }
    */

    include_once "inc/connection.php";
    include_once "inc/models.php";

    //Informations sur le client
    $client_id = $_POST['client_id'];
    $nom = $_POST['nom'];
    $profession = $_POST['pro'];
    $adresse = $_POST['adresse'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];

    //Informations sur la police
    $pol_old = $_POST['police_num_old'];
    $pol = $_POST['pol'];
    $poldf = $_POST['poldf'];
    $poldt = $_POST['poldt'];

    //Informations sur l'item de police
    $pol_item = $_POST['police_item'];

    //Information sur le véhicule
    $vehicule_id = $_POST['vehicule_id'];
    $carGenre = $_POST['carGenre'];
    $carMake = $_POST['carMake'];
    $imat = $_POST['imat'];
    $chassis = $_POST['chassis'];
    $cat = $_POST['cat'];
    $amount = $_POST['amount'];

    //Informatiions sur la vente
    $vente_id = $_POST['vente_id'];
    $vType = $_POST['vType'];
    $typAtt = $_POST['typAtt'];

    //Mise à jour du client
    $req = $bdd->prepare($models['cert_update_client']);
    $req->execute(array($nom, $profession, $adresse, $contact, $type, $client_id));
    $req->closeCursor();

    //Mise à jour de la police
    $req = $bdd->prepare($models['cert_update_police']);
    $req->execute(array($pol, $pol_old));
    $req->closeCursor();

    //Mise à jour de l'item de police
    $req = $bdd->prepare($models['cert_update_police_item']);
    $req->execute(array($poldf, $poldt, $pol_item));
    $req->closeCursor();

    //Mise à jour du vehicule
    $cat = trim(substr($cat,strrpos(trim($cat),' ')));
    $date = date('Y-m-d');
    $req = $bdd->prepare($models['cert_update_vehicule']);
    $req->execute(array($imat, $chassis, $carMake, $carGenre, $cat, $vehicule_id));
    $req->closeCursor();

    //Enregistrement de la vente
    $req = $bdd->prepare($models['cert_update_vente']);
    $req->execute(array($amount, $typAtt, $vente_id));
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