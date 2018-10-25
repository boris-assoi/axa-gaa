<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_manage_users)) {
        header("location: accesDenied.php");
    }
    
    include_once "inc/connection.php";
    
    $pos = $_POST['pos'];

    $mat = $_POST['mat'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $service = $_POST['service'];
    $ville = $_POST['ville'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $request = "INSERT INTO user (user_mat, user_nom, user_prenom, user_service, user_ville, user_username, user_password, user_is_activated, user_type) VALUES (?,?,?,?,?,?,?,1,4)";
    $req  =  $bdd->prepare($request);
	$req->execute(array($mat, $nom, $prenom, $service, $ville, $username, $password));
    $req->closeCursor();

    $request2 = "INSERT INTO commercial (comm_id, comm_pos) VALUES ((SELECT user_id FROM user WHERE user_type = 4 ORDER BY user_id DESC LIMIT 1), (SELECT pos_id FROM pos WHERE pos_nom = ?))";
    $req2 = $bdd->prepare($request2);
    $req2->execute(array($pos));
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