<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_mod_com)) {
        header("location: accesDenied.php");
    }

    include_once "inc/connection.php";
    include_once "inc/models.php";

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
    $pf = $_POST['pf'];
    $pfvalue = $_POST['pfvalue'];
    $amount = $_POST['amount'];

    //informations sur le type d'attestation
    $typAtt = $_POST['typAtt'];

    //Informatiions sur la vente
    $vType = $_POST['vType'];

    //Enregistrement du client
    $req  =  $bdd->prepare($models['cert_new_client']);
    $req->execute(array($nom, $profession, $adresse, $contact, $_SESSION['userID'], $type));
    $req->closeCursor();

    //Enregistrement de la police
    $req  =  $bdd->prepare($models['cert_new_police']);
    $req->execute(array($pol, $_SESSION['userID']));
    $req->closeCursor();

    //Enregistrement du vehicule
    $cat = trim(substr($cat,strrpos(trim($cat),' ')));
    $date = date('Y-m-d');
    $req = $bdd->prepare($models['cert_new_vehicule']);
    $req->execute(array($imat, $chassis, $carMake, $carGenre, $cat, $pol));
    $req->closeCursor();

    //Enregistrement de la vente
    $req = $bdd->prepare($models['cert_new_vente']);
    $req->execute(array($amount, $pol, $_SESSION['userID'], $vType, $typAtt));
    $req->closeCursor();

    //Enregistrement de l'item de police
    $req  =  $bdd->prepare($models['cert_new_police_item']);
    $req->execute(array($poldf, $poldt, $pol, $_SESSION['userID']));
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