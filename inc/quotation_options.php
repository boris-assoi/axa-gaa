<?php
try {
    session_start();

    include_once "acl.php";

    /*
        if (!in_array($_SESSION['type'], $acl_mod_com)) {
            header("location: accesDenied.php");
        }
        */

    include_once "connection.php";
    include_once "models.php";


    /*
		* INFORMATIONS SUR LES GARANTIES A AJOUTER 
		*/
    //Récupération du type de garantie DEFENSE ET RECOURS
    (!empty($_POST['defense'])) ? $defense = 2 : $defense = 1;

    //Récupération de l'option de la garantie SECURITE ROUTIERE
    (!empty($_POST['sec_route'])) ? $sec_route = $_POST['sec_route'] : $sec_route = 2;

    //Récupération du type de garantie DOMMAGES
    (!empty($_POST['dom'])) ? $dom = $_POST['dom'] : $dom = "";

    //Récupération de l'option de la garantie BRIS DE GLACE
    (!empty($_POST['bris'])) ? $bris = $_POST['bris'] : $bris = "";

    //Récupération de l'option de la garantie VOL ET ACCESSOIRES
    (!empty($_POST['option_vol_acc'])) ? $option_vol_acc = $_POST['option_vol_acc'] : $option_vol_acc = "";

    //Récupération du type de garantie
    (!empty($_POST['type'])) ? $type_garantie = $_POST['type'] : $type_garantie = "";

    //Récupération de la prime de la garantie RC
    (!empty($_POST['prime_rc'])) ? $prime_rc = $_POST['prime_rc'] : $prime_rc = "";

    //Récupération de prime de la garantie RA
    (!empty($_POST['prime_ra'])) ? $prime_ra = $_POST['prime_ra'] : $prime_ra = "";

    //Récupération de la durée de la police
    (!empty($_POST['poltime'])) ? $poltime = DateInterval::createFromDateString($_POST['poltime'] . 'days')  : $poltime = '';

    //Recupération de la valeur catalogue
    (!empty($_POST['valCat'])) ? $valCat = $_POST['valCat'] : $valCat = "";

    //Initialisation des variables
    $prime_dr = '';
    $prime_sr = '';
    $prime_bg = '';
    $prime_vol_acc = '';
    $prime_dom = '';
    /* 
        * CALCUL DES MONTANTS DE GARANTIES
        */

    //Variable à retourner
    $data = "";

    switch ($type_garantie) {
        case 'opt_defense_recours':
            /*
                * CALCUL DE LA GARANTIE DEFENSE ET RECOURS : prime_dr
                */
            //Récupération du forfait
            $req = $bdd->prepare("SELECT prime FROM g_def_rec WHERE type_garantie = ?");
            $req->execute(array($defense));
            while ($ok = $req->fetch()) {
                $prime_dr += $ok['prime'];
            }
            $req->closeCursor();

            $data['dr']['lib'] = "dr";
            $data['dr']['name'] = "Défense et recours";
            $data['dr']['value'] = (string)($prime_dr);
            $data['dr']['option'] = "";

            /*
                * FIN DE CALCUL DE LA GARANTIE DEFENSE ET RECOURS
                */
            break;

        case 'opt_securite_routiere':
            /*
                * CALCUL DE LA GARANTIE SECURITE ROUTIERE : prime_sr
                */
            //Récupération du paramètre dans le formulaire
            $req = $bdd->prepare("SELECT prime FROM option_g_sec_rou WHERE id = ?");
            $req->execute(array($sec_route));
            while ($ok = $req->fetch()) {
                $prime_sr += $ok['prime'];
            }
            $req->closeCursor();

            $prime_sr = ceil($prime_sr * $poltime->d / 365);

            $data['sr']['lib'] = "sr";
            $data['sr']['name'] = "Sécurité routière";
            $data['sr']['value'] = (string)($prime_sr);
            $data['sr']['option'] = "Option ".$sec_route;

            /*
                * FIN DE CALCUL DE LA GARANTIE SECURITE ROUTIERE
                */
            break;

        case 'opt_bris_glace':
            /*
                * CALCUL DE LA GARANTIE BRIS DE GLACE : prime_bg
                */

            //Variable contenant l'option
            $opt_bg = "";
            //Récupération du paramètre dans le formulaire
            $req = $bdd->prepare("SELECT prime, lib FROM g_bri_gla, option_g_bri_gla WHERE `g_bri_gla`.`option` = `option_g_bri_gla`.`id` AND `option_g_bri_gla`.`id` = ?");
            $req->execute(array($bris));
            while ($ok = $req->fetch()) {
                $prime_bg = $valCat * $ok['prime'] / 100;
                $opt_bg = $ok['lib'];
            }
            $req->closeCursor();

            $data['bg']['lib'] = "bg";
            $data['bg']['name'] = "Bris de glace";
            $data['bg']['value'] =(string)($prime_bg);
            $data['bg']['option'] = $opt_bg;

            /*
                * FIN DE CALCUL DE LA GARANTIE BRIS DE GLACE
                */
            break;

        case 'opt_vol_accessoires':
            /* 
                * CALCUL DE LA GARANTIE VOL ACCESSOIRES
                */

            //Variable contenant l'option
            $opt_vol_acc = "";
            //Récupération du paramètre dans le formulaire
            $req = $bdd->prepare("SELECT prime, assiette FROM g_vol_acc WHERE id = ?");
            $req->execute(array($option_vol_acc));
            $ok = $req->fetch();
            $prime_vol_acc = $ok['prime'];
            $opt_vol_acc = $ok['assiette'];
            $req->closeCursor();

            $data['vol_acc']['lib'] = "vol_acc";
            $data['vol_acc']['name'] = "Vol d'accessoires";
            $data['vol_acc']['value'] = $prime_vol_acc;
            $data['vol_acc']['option'] = $opt_vol_acc;

            /* 
                * FIN DE CALCUL DE LA GARANTIE VOL ACCESSOIRES
                */
            break;

        default:
            # code...
            break;
    }

    /* 
        * TOTAL PRIME POUR LE TIERS DE BASE : $prime_tb 
        */
    $prime_tb = $prime_rc + $prime_dr + $prime_ra + $prime_sr;

    /* RETOUR DU TEXTE A LA REQUETE AJAX */
    echo json_encode($data);
} catch (Exception $e) {
    die('Erreur:' . $e->getMessage());
}
