<?php
try
{
    session_start();

    include_once "inc/acl.php";

    /*
    if (!in_array($_SESSION['type'], $acl_mod_com)) {
        header("location: accesDenied.php");
    }
    */
    
    include_once "inc/connection.php";
    include_once "inc/models.php";

    $to = $_POST['to'];

    if ($_SESSION['type'] == "superviseur") {
        $to = trim(substr($to,strrpos(trim($to),' ')));
    }
    
    $nAtt = (int) htmlspecialchars($_POST['nAtt']);
    $nbAtt = (int) htmlspecialchars($_POST['nbAtt']);
    $typAtt = htmlspecialchars($_POST['typAtt']);

    $tabErrors = array();
    $nAttChecker = $nAtt;

    for ($i=0; $i < $nbAtt; $i++) { 
        $req = $bdd->prepare($models['validCert']);
        $req -> execute(array($nAttChecker, $_SESSION['userID'], $typAtt));
        if (!($ok=$req->fetch())) {
            $tabErrors[$i] = $nAttChecker;
        } else {
            echo $nAttChecker." <br>";
        }
       
        $req->closeCursor();
        $nAttChecker++;
    }

    if (empty($tabErrors)) {
        $req  =  $bdd->prepare($models['attrib']);
        $req->bindParam(':to', $to, PDO::PARAM_INT);
        $req->bindParam(':type', $typAtt, PDO::PARAM_INT);
        $nAttF = $nAtt - 1;
        $req->bindParam(':f', $nAttF, PDO::PARAM_INT);
        $nAttT = $nAtt + $nbAtt;
        $req->bindParam(':t', $nAttT, PDO::PARAM_INT);
        $req->bindParam(':dernier', $nbAtt, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();

        header('location: listCertificate.php');

    } else {
        header('location: accesDenied.php');
    }
    
    /*
	$messageType = "commercial";
    $action = "mod";

    header('location: addConfirmed.php?m='.$messageType.'&action='.$action);
    */
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 