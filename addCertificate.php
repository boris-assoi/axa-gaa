<?php
try
{
    session_start();

    include_once "inc/acl.php";

    //if (!in_array($_SESSION['type'], $acl_add_sub)) {
    //    header("location: accesDenied.php");
    //}
    include_once "inc/connection.php";
    
    $nAtt = (int) htmlspecialchars($_POST['nAtt']); 
    $nbAtt = (int) htmlspecialchars($_POST['nbAtt']);
    $typAtt = htmlspecialchars($_POST['typAtt']);
    $dateBatch = htmlspecialchars($_POST['dateBatch']);
    $tabErrors = array();
    $nAttChecker = $nAtt;
    $batchNom = "";

    //Vérification des ID
    for ($i=0; $i < $nbAtt; $i++) { 
        $request = 'SELECT attestation_num FROM attestation WHERE attestation_num = ?';
        $req  =  $bdd->prepare($request);
        $req->execute(array($nAttChecker));
        while ($ok = $req->fetch()) {
            $tabErrors[] = $nAttChecker;
        }
        $req->closeCursor();
        $nAttChecker++;
    }

    if (empty($tabErrors)) {
        switch ($typAtt) {
            case 'automobile':
                $batchNom = "LotAUT";
                break;

            case 'carte brune CEDEAO':
                $batchNom = "LotCEDEAO";
                break;

            case 'carte verte 2 roues':
                $batchNom = "Lot2ROUES";
                break;
            
            default:
                # code...
                break;
        }
        $batchNom .= date('Ymd');
        $nAttFin = $nAtt + $nbAtt - 1;

        $request = 'INSERT INTO batch (batch_nom, batch_num_debut, batch_num_fin, batch_nbre, batch_date_recp, batch_type) VALUES (?,?,?,?,?,(SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?))';
        $req  =  $bdd->prepare($request);
        $req->execute(array($batchNom, $nAtt, $nAttFin, $nbAtt, $dateBatch, $typAtt));
        $req->closeCursor();

        for ($i=0; $i < $nbAtt; $i++) {
            $request = 'INSERT INTO attestation (attestation_num, attestation_statut, attestation_date, attestation_admin, attestation_type, attestation_batch) VALUES (?,?,?,?,(SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?),(SELECT batch_id FROM batch ORDER BY batch_id DESC LIMIT 1))';
            $req  =  $bdd->prepare($request);
            $req->execute(array($nAtt, "En Stock", $dateBatch, $_SESSION['userID'], $typAtt));
            $req->closeCursor();
            $nAtt++;
        }

        header('location: listBatch.php');

    } else {
        header('location: accesDenied.php');
    }
    
    
    

	//$messageType = "subscriber";
    //$action = "add";

    //header('location: addConfirmed.php?m='.$messageType.'&action='.$action);
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 