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
        $cat = $_POST['cat'];

        //Variable contenant les valeurs de puissance fiscale à restituer
        $output = '';

        //Recupération des valeurs dans la base de données
        $req = $bdd->prepare('SELECT cat_vehicule_desc FROM categorie_vehicule WHERE cat_vehicule_lib = ?');
        $req -> execute(array($cat));
        while ($ok = $req->fetch()) {
            $output .= '<span>'.$ok['cat_vehicule_desc'].'</span>';
        }
        echo $output;

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 