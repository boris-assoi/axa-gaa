<?php
try
{
    session_start();

    include_once "inc/acl.php";

    if (!in_array($_SESSION['type'], $acl_manage_settings)) {
        header("location: accesDenied.php");
    }

    include_once "inc/connection.php";
    include_once "inc/models.php";

    //Récupération du mot de passe depuis la base de données
    $req = $bdd->prepare($models['pass_check']);
    $req -> execute(array($_SESSION['userID']));
    $ok = $req->fetch();

    //Récupération des mots de passe
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $confirmpass = $_POST['confirmpass'];

    if ($oldpass !== $ok['user_password']) {
        $error = "Le mot de passe actuel saisi n'est pas correct";
        echo $error;
    } elseif ($newpass !== $confirmpass) {
        $error = "les nouveaux mots de passe saisis ne sont pas identiques";
        echo $error;
    } else {
        //Mise à jour du mot de passe
        $req = $bdd->prepare($models['pass_update']);
        $req -> execute(array($newpass, $_SESSION['userID']));
    }

    echo "L'ancien mot de passe est : ".$oldpass."<br>Le nouveau mot de passe est : ".$newpass."<br>La confirmation du nouveau mot de passe est : ".$confirmpass;


    //header('location: mySales.php');
    
    /*
	$messageType = "commercial";
    $action = "mod";
    */
    $message = "Mot de passe modifié avec succès";

    header('location: confirmed.php?m='.$message);
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 