<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_manage_users)) {
        header("location: accesDenied.php");
    }
    include_once "inc/connection.php";
    
    $mat = $_POST['mat'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $service = $_POST['service'];
    $ville = $_POST['ville'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $request = "INSERT INTO user (user_mat, user_nom, user_prenom, user_service, user_ville, user_username, user_password, user_parent, user_is_activated, user_type) VALUES (?,?,?,?,?,?,?,?,1,2)";
    $req = $bdd->prepare($request);
	$req->execute(array($mat, $nom, $prenom, $service, $ville, $username, $password, $_SESSION['userID']));
    $req->closeCursor();

    $request2 = "INSERT INTO r_commercial (r_comm_id) VALUES ((SELECT user_id FROM user WHERE user_type = 2 ORDER BY user_id DESC LIMIT 1))";
    $req2 = $bdd->prepare($request2);
    $req2->execute(array($_SESSION['userID']));
    $req2->closeCursor();
    
    header('location: users.php');

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