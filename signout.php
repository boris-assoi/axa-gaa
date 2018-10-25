<?php
try
{
	session_start();
	$_SESSION['connect']=null;
	$_SESSION['userID']=null;
	$_SESSION['userPrenom']=null;
	$_SESSION['userNom']=null;
	header("location: login.php");
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 