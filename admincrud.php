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

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch ($action) {
        case 'add':
            $mat = htmlspecialchars($_POST['mat']);
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $service = htmlspecialchars($_POST['service']);
            $ville = htmlspecialchars($_POST['ville']);
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $request = 'INSERT INTO user (user_mat, user_nom, user_prenom, user_service, user_ville, user_username, user_password, user_is_activated, user_type) VALUES (?,?,?,?,?,?,?,1,1)';
            $req = $bdd->prepare($request);
            $req->execute(array($mat, $nom, $prenom, $service, $ville, $username, $password));
            $req->closeCursor();

            $request = 'INSERT INTO administrateur (administrateur_id) 
            VALUES ((SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1))';
            $req = $bdd->prepare($request);
            $req->execute(array($_SESSION['userID']));
            $req->closeCursor();

            $request = 'INSERT INTO log (log_content, log_type) 
            VALUES (?, 1)';
            $req = $bdd->prepare($request);
            $log = "Ajout d'un nouvel administrateur :".$prenom." ".$nom." par ".$_SESSION['userPrenom']." ".$_SESSION['userNom'];
            $req->execute(array($log));
            $req->closeCursor();

            break;
        
        case 'del':
            # code...
            break;

        case 'update':
            # code...
            break;

        default:
            # code...
            break;
    }
    
    
    
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