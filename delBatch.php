<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_manage_store)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/connection.php";
    include_once "inc/models.php";
    
    $batch = $_GET['bID'];
    $date = date('Y/m/d');

    $tabErrors = array();
    $req = $bdd->prepare("SELECT attestation_ug FROM attestation WHERE attestation_batch = ?");
    $req -> execute(array($batch));
    while ($ok=$req->fetch()) {
        if($ok['attestation_ug']){
            array_push($tabErrors, $ok['attestation_ug']);
        }
    }
    $req->closeCursor();
    
    if($tabErrors){
        header('location: accesDenied.php');
    } else {
        $req = $bdd->prepare($models['cancel_batch']);
        $req->execute(array($batch));
        $req->closeCursor();
    }
    
    header('location: listBatch.php');

    /*
	$messageType = "subscriber";
    $action = "add";

    header('location: addConfirmed.php?m='.$messageType.'&action='.$action);
    */
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 