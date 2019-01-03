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

        //Récupération des informations de la police (date d'effet, durée en jours)
        (!empty($_POST['poldf'])) ? $poldf = new DateTime($_POST['poldf'], new DateTimeZone('GMT+0')) : $poldf = '';

        (!empty($_POST['poltime'])) ? $poltime = DateInterval::createFromDateString($_POST['poltime']. 'days')  : $poltime = '';


        //Variable contenant les valeurs à restituer
        $output = '';

        switch ($type) {
            //Recupération des statuts socio-professionnels
            case 'socio-pro':
                $req = $bdd->prepare('SELECT info FROM statut_socio_pro WHERE lib = LOWER(?)');
                $req -> execute(array($stat));
                while ($ok = $req->fetch()) {
                    $output .= '<span>'.$ok['info'].'</span>';
                }
                break;

            //Récupération des valeurs de puissance fiscale
            case 'puissance-fiscale':
                $req = $bdd->prepare('SELECT label FROM '.$pfType);
                $req -> execute(array($pfType));
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
            //calcul de la date d'échéance de la police
            case 'echeance-police':
                $poldt = $poldf->add($poltime);
                $output = $poldt->format('d/m/Y');
                break;
            
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