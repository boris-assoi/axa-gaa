<?php
try
{
	session_start();
 	include_once "inc/connection.php";
    $user = $_POST['userID'];
    $pass=$_POST['userPass'];
    $request = 'SELECT user.user_id, user.user_nom, user.user_prenom, user.user_type, type_user.type_user_lib as libelle FROM user, type_user WHERE user.`user_type`=type_user.type_user_id AND user.user_username=? AND user.user_password=?';
    $req = $bdd->prepare($request);
	$req->execute(array($user,$pass));
	$ok = $req->fetch();
	if ($ok) {
		$_SESSION['userID']=$ok['user_id'];
		$_SESSION['userPrenom']=$ok['user_prenom'];
		$_SESSION['userNom']=$ok['user_nom'];
		$_SESSION['type'] = $ok['libelle'];
		$_SESSION['connect']=1;
		header("location: index.php");
	}
	else{
		header("location: loginFailed.php");
	}
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 