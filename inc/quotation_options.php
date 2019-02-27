<?php
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


       	/*
		* INFORMATIONS SUR LES GARANTIES A AJOUTER 
		*/
		//Récupération du type de garantie DEFENSE ET RECOURS
		(!empty($_POST['defense'])) ? $defense = 1 : $defense = 2;

		//Récupération de l'option de la garantie SECURITE ROUTIERE
		(!empty($_POST['sec_route'])) ? $sec_route = $_POST['sec_route'] : $sec_route = 2;

		//Récupération du type de garantie DOMMAGES
		(!empty($_POST['dom'])) ? $dom = $_POST['dom'] : $dom = "";

		//Récupération de l'option de la garantie BRIS DE GLACE
        (!empty($_POST['bris'])) ? $bris = $_POST['bris'] : $bris = "";
        
		//Récupération de l'option de la garantie VOL ET ACCESSOIRES
        (!empty($_POST['option_vol_acc'])) ? $option_vol_acc = $_POST['option_vol_acc'] : $option_vol_acc = "";
        
		//Récupération de l'option de la garantie VEHICULE DE REMPLACEMENT
        (!empty($_POST['option_veh_rem'])) ? $option_veh_rem = $_POST['option_veh_rem'] : $option_veh_rem = "";

        //Récupération du type de garantie
        (!empty($_POST['type'])) ? $type_garantie = $_POST['type'] : $type_garantie = "";

        //Récupération de la prime de la garantie RC
        (!empty($_POST['prime_rc'])) ? $prime_rc = $_POST['prime_rc'] : $prime_rc = "";

        //Récupération de prime de la garantie RA
        (!empty($_POST['prime_ra'])) ? $prime_ra = $_POST['prime_ra'] : $prime_ra = "";

        //Récupération de la durée de la police
        (!empty($_POST['poltime'])) ? $poltime = DateInterval::createFromDateString($_POST['poltime']. 'days')  : $poltime = '';
        
        //Recupération de la valeur catalogue
        (!empty($_POST['valCat'])) ? $valCat = $_POST['valCat'] : $valCat = "";
        
        //Initialisation des variables
        $prime_dr = '';
        $prime_sr = '';
        $prime_bg = '';
        $prime_vol_acc = '';
        $prime_dom = '';
        $prime_veh_rem = '';
        /* 
        * CALCUL DES MONTANTS DE GARANTIES
        */

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

                $output = $prime_dr;
                // echo "Prime DR : ".$data['prime_dr']."<br>";
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

                $output = $prime_sr;
                // echo "Prime SR : ".$data['prime_sr']."<br>";
                /*
                * FIN DE CALCUL DE LA GARANTIE SECURITE ROUTIERE
                */
                break;

            case 'opt_bris_glace':
                /*
                * CALCUL DE LA GARANTIE BRIS DE GLACE : prime_bg
                */
                //Récupération du paramètre dans le formulaire
                $req = $bdd->prepare("SELECT prime FROM g_bri_gla, option_g_bri_gla WHERE `g_bri_gla`.`option` = `option_g_bri_gla`.`id` AND `option_g_bri_gla`.`id` = ?");
                $req->execute(array($bris));
                while ($ok = $req->fetch()) {
                    $prime_bg = $valCat * $ok['prime'] / 100;
                }
                $req->closeCursor();

                $output = $prime_bg;
                // echo "Prime BG : ".$data['prime_bg']."<br>";
                /*
                * FIN DE CALCUL DE LA GARANTIE BRIS DE GLACE
                */
                break;

            case 'opt_vol_accessoires':
                /* 
                * CALCUL DE LA GARANTIE VOL ACCESSOIRES
                */
                //Récupération du paramètre dans le formulaire
                $req = $bdd->prepare("SELECT prime FROM g_vol_acc WHERE id = ?");
                $req->execute(array($option_vol_acc));
                $ok = $req->fetch();
                $prime_vol_acc = $ok['prime'];
                $req->closeCursor();

                $output = $prime_vol_acc;

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

        switch ($type_garantie) {
            //case 'opt_dommages':
                /*
                * CALCUL DE LA GARANTIE DOMMAGES : prime_dom
                */
                //Récupération du paramètre dans le formulaire
                /* $req = $bdd->prepare("SELECT prime FROM g_dom WHERE g_dom.type = ?");
                $req->execute(array($dom));
                while ($ok = $req->fetch()) {
                    $prime_dom += ceil($ok['prime'] * $prime_tb / 100);
                }
                $req->closeCursor();

                $output = $prime_dom; */
                // echo "Prime DOM : ".$data['prime_dom']."<br>";
                /*
                * FIN DE CALCUL DE LA GARANTIE DOMMAGES
                */
                //break;

            //case 'opt_vehicule_remplacement':
                /* 
                * CALCUL DE LA GARANTIE VEHICULE DE REMPLACEMENT
                */
                //Détermination du type de prime(annuelle ou semestrielle)
               /*  $type_taux = '';
                if(($poltime->d / 30) > 0 && ($poltime->d / 30) <= 6){
                    $type_taux = 'prime_sem';
                }elseif (($poltime->d / 30) > 6 && ($poltime->d / 30) <= 12) {
                    $type_taux = 'prime_an';
                }

                //Récupération du paramètre dans le formulaire
                $req = $bdd->prepare("SELECT ? FROM g_veh_rem WHERE assiette = ?");
                $req->execute(array($type_taux, $option_veh_rem));
                $ok = $req->fetch();

                if($option_veh_rem == '> 25 000 000 FCFA'){
                    $prime_veh_rem = $prime_tb * $ok[$type_taux];
                } else{
                    $prime_veh_rem = $ok[$type_taux];
                }
                
                $req->closeCursor();

                $output = $prime_veh_rem; */

                /* 
                * FIN DE CALCUL DE LA GARANTIE VEHICULE DE REMPLACEMENT
                */
                //break;
            
            default:
                # code...
                break;
        }

        /* RETOUR DU TEXTE A LA REQUETE AJAX */
        echo $output;

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 