<?php
    //Calcul de la garantie de la responsabilité civile
    try
    {
        session_start();

        include_once "acl.php";
        include_once "utilities.php";

        /*
        if (!in_array($_SESSION['type'], $acl_mod_com)) {
            header("location: accesDenied.php");
        }
        */

        include_once "connection.php";
        include_once "models.php";

        $type = $_POST['type'];

        //recupération du statut socio-professionnel
        if (!empty($_POST['stat'])) {
            $stat = $_POST['stat'];
        }

        //recupération de la catégorie du véhicule
        if (!empty($_POST['cat'])) {
            $cat = $_POST['cat'];
        }

        //recupération de la puissance fiscale
        if (!empty($_POST['pfType'])) {
            $pfType = 'ref_'.$_POST['pfType'];
        }

        //recupération de la classe d'ancienneté du permis
        if (!empty($_POST['classe'])) {
            $classe = $_POST['classe'];
        }

        //Recupération de la valeur catalogue
        if (!empty($_POST['valCat'])) {
            $valCat = $_POST['valCat'];
        }

        //Recupération de la date de mise en circulation
        if (!empty($_POST['dateCirculation'])) {
            $dateCirc = new DateTime($_POST['dateCirculation'], new DateTimeZone('GMT+0'));
        }

        //Variable contenant les valeurs à restituer
        $output = '';

        switch ($type) {
            //Recupération des statuts socio-professionnels
            case 'socio-pro':
                $req = $bdd->prepare('SELECT info FROM statut_socio_pro WHERE lib = LOWER(?)');
                $req -> execute(array($stat));
                while ($ok = $req->fetch()) {
                    $output .= $ok['info'];
                }
                break;

            //Récupération des valeurs de puissance fiscale
            case 'puissance-fiscale':
                $req = $bdd->prepare('SELECT label FROM '.$pfType);
                $req -> execute(array($pfType));
                $output = '<option value="">Sélectionnez la puissance fiscale</option>';
                while ($ok = $req->fetch()) {
                    $output .= '<option value="'.$ok['label'].'">'.$ok['label'].'</option>';
                }
                break;
            
            //Récupération des valeurs de puissance fiscale
            case 'cls-pc':
                $req = $bdd->prepare('SELECT info FROM classe_permis WHERE lib = LOWER(?)');
                $req -> execute(array($classe));
                while ($ok = $req->fetch()) {
                    $output .= '<span>'.$ok['info'].'</span>';
                }
                break;

            //Recupération des descriptions des catégories
            case 'cat':
                $req = $bdd->prepare('SELECT cat_vehicule_desc FROM categorie_vehicule WHERE cat_vehicule_lib = ?');
                $req -> execute(array($cat));
                while ($ok = $req->fetch()) {
                    $output .= '<span>'.$ok['cat_vehicule_desc'].'</span>';
                }
                break;

            case 'valeur-venale':
                $output = valeurVenale($valCat, $dateCirc);
            
            default:
                # code...
                break;
        }

        echo $output;

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 