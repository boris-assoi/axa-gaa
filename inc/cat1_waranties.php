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

        /*
        * INFORMATIONS SUR LE CLIENT
        */
        //Récupération de la classe d'ancienneté du permis
        $classe_permis = $_POST['classe_permis'];

        //Récupération du statut socio-professionnel
        $statut_pro = $_POST['status-pro'];

        /*
        * INFORMATIONS SUR LA POLICE
        */
        //Récupération de la date de début d'effet
        (!empty($_POST['poldf'])) ? $poldf = new DateTime($_POST['poldf'], new DateTimeZone('GMT+0')) : $poldf = '';

        //Récupération de la date de fin d'effet
        (!empty($_POST['poldt'])) ? $poldt = new DateTime($_POST['poldt'], new DateTimeZone('GMT+0')) : $poldt = '';

        //Calcul de la durée de la police
        $pol_duration = $poldf->diff($poldt);;
        echo $pol_duration->format('%m mois');


        /*
        * INFORMATIONS SUR LE VEHICULE
        */
        //Récupération du type de puissance fiscale
        $pf = $_POST['pf'];
        $pf_table = "ref_".$pf;
        
        //Récupération de la valeur de la puissance fiscale
        $pfValue = $_POST['pfValue'];

        //Récupération de la valeur catalogue du véhicule
        $valCat = $_POST['valCat'];

        //Vérification de l'existence d'une remorque        
        (!empty($_POST['rem'])) ? $rem = $_POST['rem']:$rem = '';

        /*
        *CALCUL DE LA GARANTIE RESPONSABILITE CIVILE : prime_rc
        */

        //Valeur de pourcentage annexe à appliquer
        $prime_annexe = "";

        //Recupération de la prime de base
        $prime = "";
        $req = $bdd->prepare("SELECT zone1 AS prime FROM prime_rc_cat1, ".$pf_table." WHERE es = ".$pf_table.".id AND ".$pf_table.".label = ?");
        $req->execute(array($pfValue));
        while ($ok = $req->fetch()) {
            $prime = $ok['prime'];
        }
        $req->closeCursor();

        //Ajout pour la remorque
        if (!empty($rem)) {
            $prime_annexe += 10;
        }

        //Ajout pour la classe d'ancienneté
        if ($classe_permis == "classe 2") {
            $prime_annexe += (-5);
        }
        
        $prime_stt_pro = '';
        //Ajout pour le statut socio-professionnel
        if ($statut_pro == "a" || $statut_pro == "b" || $statut_pro == "c") {
            $prime_annexe += (-5);
        } elseif ($statut_pro == "d" || $statut_pro == "e") {
            $prime_annexe += (-10);
        }

        $prime_rc = $prime + ($prime * $prime_annexe / 100);

        echo "Calcul de la prime pour la garantie de la RESPONSABILITE CIVILE <br>";
        echo "Prime de base : ".$prime."<br>";
        echo "Prime annexe : ".$prime_annexe."<br>";
        echo "Le montant de la prime :".$prime_rc."<br>";

        /*
        * FIN DE CALCUL DE LA GARANTIE DE LA RESPONSABILITE CIVILE
        */

        /*
        * CALCUL DE LA GARANTIE DEFENSE ET RECOURS : prime_dr
        */
        $prime_dr = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['defense'])){
            $req = $bdd->prepare("SELECT prime FROM g_def_rec,type_g_def_rec WHERE type_garantie = `type_g_def_rec`.`id` AND `type_g_def_rec`.`lib` = LOWER(?)");
            $req->execute(array($_POST['defense']));
            while ($ok = $req->fetch()) {
                $prime_dr += $ok['prime'];
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie de DEFENSE ET RECOURS<br>";
        echo "Prime de base : ".$prime_dr."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE DEFENSE ET RECOURS
        */

        /*
        * CALCUL DE LA GARANTIE REMBOURSEMENT ANTICIPE : prime_ra
        */
        $prime_ra = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $req = $bdd->prepare("SELECT prime FROM g_rem_ant, prime_g_rem_ant WHERE type_prime = `prime_g_rem_ant`.`id` AND `prime_g_rem_ant`.`lib` = LOWER(?)");
            $req->execute(array($_POST['remb']));
            while ($ok = $req->fetch()) {
                $prime_ra += $ok['prime'];
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie de REMBOURSEMENT ANTICIPE<br>";
        echo "Prime de base : ".$prime_ra."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE REMBOURSEMENT ANTICIPE
        */

        /*
        * CALCUL DE LA GARANTIE BRIS DE GLACE : prime_bg
        */
        $prime_bg = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $req = $bdd->prepare("SELECT prime FROM g_bri_gla, option_g_bri_gla WHERE `g_bri_gla`.`option` = `option_g_bri_gla`.`id` AND `option_g_bri_gla`.`lib` = LOWER(?)");
            $req->execute(array($_POST['bris']));
            while ($ok = $req->fetch()) {
                $prime_bg += $ok['prime'] * $valCat / 100;
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie BRIS DE GLACE<br>";
        echo "Prime de base : ".$prime_bg."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE BRIS DE GLACE
        */

        /*
        * CALCUL DE LA GARANTIE DOMMAGES : prime_dom
        */
        $prime_dom = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $req = $bdd->prepare("SELECT prime FROM g_dom, type_g_dom WHERE `g_dom`.`type` = `type_g_dom`.`id` AND `type_g_dom`.`lib` = LOWER(?)");
            $req->execute(array($_POST['remb']));
            while ($ok = $req->fetch()) {
                $prime_dom += $ok['prime'];
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie de DOMMAGES<br>";
        echo "Prime de base : ".$prime_dom."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE DOMMAGES
        */

        /*
        * CALCUL DE LA GARANTIE VANDALISME : prime_van
        */
        $prime_van = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $req = $bdd->prepare("SELECT forfait FROM g_van");
            $req->execute(array($_POST['remb']));
            while ($ok = $req->fetch()) {
                $prime_van += $ok['forfait'];
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie de VANDALISME<br>";
        echo "Prime de base : ".$prime_van."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE VANDALISME
        */

        /*
        * CALCUL DE LA GARANTIE SECURITE ROUTIERE : prime_sr
        */
        $prime_sr = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $req = $bdd->prepare("SELECT prime FROM option_g_sec_rou WHERE lib =?");
            $req->execute(array($_POST['sec_rou_opt']));
            while ($ok = $req->fetch()) {
                $prime_sr += $ok['prime'];
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie de SECURITE ROUTIERE<br>";
        echo "Prime de base : ".$prime_sr."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE SECURITE ROUTIERE
        */

        /*
        * CALCUL DE LA GARANTIE IMMOBILISATION : prime_im
        */
        $prime_im = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $req = $bdd->prepare("SELECT prime FROM option_g_sec_rou WHERE lib =?");
            $req->execute(array($_POST['sec_rou_opt']));
            while ($ok = $req->fetch()) {
                $prime_im += $ok['prime'];
            }
            $req->closeCursor();
        }

        echo "Calcul de la prime pour la garantie de IMMOBILISATION<br>";
        echo "Prime de base : ".$prime_im."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE IMMOBILISATION
        */

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 