<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_manage_certs)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/inc_function.php";

    include_once "inc/connection.php";
    
    $nom = $_POST['nom'];
    $profession = $_POST['pro'];
    $adresse = $_POST['adresse'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];

    $request = 'INSERT INTO client (client_nom, client_profession, client_adresse, client_contact, client_comm, client_type) 
    VALUES (?,?,?,?,?,(SELECT type_client_id FROM type_client WHERE type_client_lib = ?))';
    $req  =  $bdd->prepare($request);
	$req->execute(array($nom, $profession, $adresse, $contact, $_SESSION['userID'], $type));
    $req->closeCursor();
    
    header('location: listClients.php');

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