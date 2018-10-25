<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_add_sub)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/inc_function.php";

    include_once "inc/connection.php";
    
    $nom = "UG - ".$_POST['nom'];
    $code = $_POST['code'];
    $localite = $_POST['localite'];
    $rcomm = $_POST['rcomm'];

    $rcommMat = trim(substr($rcomm,strrpos(trim($rcomm),' ')));

    $request = 'INSERT INTO unit_gestion (ug_nom, ug_code, ug_localite, ug_r_comm) 
    VALUES (?,?,?,(SELECT user_id FROM user WHERE user_mat = ?))';
    $req  =  $bdd->prepare($request);
	$req->execute(array($nom, $code, $localite, $rcommMat));
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