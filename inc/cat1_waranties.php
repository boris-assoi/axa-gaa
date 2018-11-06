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
        $datePC = $_POST['datePC'];

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
        echo $pf;
        $pfValue = $_POST['pfValue'];
        $amount = $_POST['amount'];

        //informations sur le type d'attestation
        $typAtt = $_POST['typAtt'];

        //Informatiions sur la vente
        $vType = $_POST['vType'];

        //Recupération de la prime de base
        $prime = "";
        $req = $bdd->prepare("SELECT zone1 AS prime FROM prime_rc_cat1, ref_essence WHERE es = ref_essence.id AND ref_essence.label = ?");
        $req->execute(array($pfValue));
        while ($ok = $req->fetch()) {
            $prime = $ok['prime'];
        }
        echo $prime;

        //Détermination de la classe d'ancienneté
        $currentYear = date('Y');
        $classePC = $currentYear - $datePC;
        echo $classePC;
    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 