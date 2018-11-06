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

        //recupération du type de puissance fiscale
        $pfType = 'ref_'.$_POST['pfType'];

        //Variable contenant les valeurs de puissance fiscale à restituer
        $output = '';

        //Recupération des valeurs dans la base de données
        $req = $bdd->prepare('SELECT label FROM '.$pfType);
        $req -> execute(array($pfType));
        $output = '<option value="">Selectionner la puissance fiscale</option>';
        while ($ok = $req->fetch()) {
            $output .= '<option value="'.$ok['label'].'">'.$ok['label'].'</option>';
        }
        echo $output;

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 