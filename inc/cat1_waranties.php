<?php
    //Calcul de la garantie de la responsabilité civile
    try
    {
        session_start();

        include_once "acl.php";

        /*
        if (!in_array($_SESSION['type'], $acl_mod_com)) {
            header("location: accesDenied.php");
        }
        */

        include_once "connection.php";
        include_once "models.php";

        //Informations sur le client
        $nom = $_POST['nom'];
        echo $nom;
        $profession = $_POST['pro'];
        $adresse = $_POST['adresse'];
        $contact = $_POST['contact'];
        $type = $_POST['type'];

        //Informations sur la police
        $pol = $_POST['pol'];
        $poldf = $_POST['poldf'];
        $poldt = $_POST['poldt'];

        //Information sur le véhicule
        $carGenre = $_POST['carGenre'];
        $carMake = $_POST['carMake'];
        $imat = $_POST['imat'];
        $chassis = $_POST['chassis'];
        $cat = $_POST['cat'];
        $pf = $_POST['pf'];
        $pfValue = $_POST['pfValue'];
        echo $pfValue;
        $amount = $_POST['amount'];

        //informations sur le type d'attestation
        $typAtt = $_POST['typAtt'];

        //Informatiions sur la vente
        $vType = $_POST['vType'];

        //Recupération de la prime de base
        $prime = "";
        $req = $bdd->prepare("SELECT zone1 AS prime FROM g_resp_civ WHERE essence = (SELECT lib FROM essence WHERE label = ?)");
        $req->execute(array($pfValue));
        while ($ok = $req->fetch()) {
            $prime = $ok['prime'];
        }
        echo $prime;
        
    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 