<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_add_sub)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/connection.php";
    include_once "inc/models.php";
    
    $att = $_GET['att'];
    $desc = "Annulation par ".$_SESSION['userPrenom']." ".$_SESSION['userNom']." depuis l'interface.";
    
    $req  =  $bdd->prepare($models['cancel_cert']);
	$req->execute(array($desc, $att));
    $req->closeCursor();
    
    header('location: listCertificate.php');

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