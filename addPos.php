<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_manage_centers)) {
        header("location: accesDenied.php");
    }

    include_once "inc/connection.php";
    
    $nom = $_POST['nom'];
    $localite = $_POST['localite'];
    $contact = $_POST['contact'];
    $ug = $_POST['ug'];
    $sup = $_POST['sup'];

    $ugMat = trim(substr($ug,strrpos(trim($ug),' ')));
    $supMat = trim(substr($sup,strrpos(trim($sup),' ')));

    $request = 'INSERT INTO pos (pos_nom, pos_localite, pos_contact, pos_ug, pos_superviseur) 
    VALUES (?,?,?,(SELECT ug_id FROM unit_gestion WHERE ug_code = ?),(SELECT user_id FROM user WHERE user_mat = ?))';
    $req  =  $bdd->prepare($request);
	$req->execute(array($nom, $localite, $contact, $ugMat, $supMat));
    $req->closeCursor();
    
    header('location: index.php');

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