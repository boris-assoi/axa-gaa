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
        $stat = $_POST['stat'];

        //Variable contenant les valeurs de puissance fiscale à restituer
        $output = '';

        //Recupération des valeurs dans la base de données
        $req = $bdd->prepare('SELECT info FROM statut_socio_pro WHERE lib = LOWER(?)');
        $req -> execute(array($stat));
        while ($ok = $req->fetch()) {
            $output .= '<span>'.$ok['info'].'</span>';
        }
        echo $output;

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 