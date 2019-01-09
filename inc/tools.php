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
        * INFORMATIONS SUR L'ATTESTATION
        */
        //Recupération du type d'attestation
        (!empty($_POST['typAtt'])) ? $typAtt = $_POST['typAtt'] : $typAtt = "";        

        /*
        * INFORMATIONS SUR LE CLIENT
        */
        //Recupération du type de client
        (!empty($_POST['typeClient'])) ? $typeClient = $_POST['typeClient'] : $typeClient = "";
        
        //Recupération du nom du client
        (!empty($_POST['nomClient'])) ? $nomClient = $_POST['nomClient'] : $nomClient = "";

        //Recupération de la classe d'ancienneté du permis de conduire du client
        (!empty($_POST['classe_permis'])) ? $classe_permis = $_POST['classe_permis'] : $classe_permis = "";

        //Recupération du statut socio-professionnel du client
        (!empty($_POST['statut_pro'])) ? $statut_pro = $_POST['statut_pro'] : $statut_pro = "";

        //Recupération de la profession du client
        (!empty($_POST['pro'])) ? $pro = $_POST['pro'] : $pro = "";

        //Recupération de l'adresse du client
        (!empty($_POST['adresse'])) ? $adresse = $_POST['adresse'] : $adresse = "";

        //Recupération du contact du client
        (!empty($_POST['contact'])) ? $contact = $_POST['contact'] : $contact = "";

        /*
        * INFORMATIONS SUR LA POLICE
        */
        //Recupération du numéro de police
        (!empty($_POST['pol'])) ? $pol = $_POST['pol'] : $pol = "";

        //Récupération de la date de début d'effet
        (!empty($_POST['poldf'])) ? $poldf = new DateTime($_POST['poldf'], new DateTimeZone('GMT+0')) : $poldf = '';

        //Récupération de la date de fin d'effet
        (!empty($_POST['poldt'])) ? $poldt = new DateTime($_POST['poldt'].'+1 day', new DateTimeZone('GMT+0')) : $poldt = '';

        //Récupération de la durée de la police
        (!empty($_POST['poltime'])) ? $poltime = DateInterval::createFromDateString($_POST['poltime']. 'days')  : $poltime = '';


        /*
        * INFORMATIONS SUR LE VEHICULE
        */
        //Recupération de la catégorie du véhicule
        (!empty($_POST['catCar'])) ? $catCar = $_POST['catCar'] : $catCar = "";

        //Recupération du genre
        (!empty($_POST['carGenre'])) ? $carGenre = $_POST['carGenre'] : $carGenre = "";

        //Recupération de la marque
        (!empty($_POST['carMake'])) ? $carMake = $_POST['carMake'] : $carMake = "";

        //Recupération du numéro d'immatriculation
        (!empty($_POST['imat'])) ? $imat = $_POST['imat'] : $imat = "";

        //Recupération de la date de mise en circulation
        (!empty($_POST['dateCirc'])) ? $dateCirc = $_POST['dateCirc'] : $dateCirc = "";

        //Recupération de la puissance fiscale
        (!empty($_POST['pf'])) ? $pf = $_POST['pf'] : $pf = "";
        $pf_table = "ref_".$pf;
        
        //Recupération de la valeur de la puissance fiscale
        (!empty($_POST['pfValue'])) ? $pfValue = $_POST['pfValue'] : $pfValue = "";

        //Recupération de la valeur catalogue
        (!empty($_POST['valCat'])) ? $valCat = $_POST['valCat'] : $valCat = "";

        //Recupération de la valeur vénale
        (!empty($_POST['valVen'])) ? $valVen = $_POST['valVen'] : $valVen = "";

        //Vérification de l'existence d'une remorque        
        (!empty($_POST['rem'])) ? $rem = $_POST['rem'] : $rem = '';

        /* 
        * INFORMATIONS SUR LA FORMULE DE GARANTIES
        */
        //Récupération de la garantie sélectionnée
        (!empty($_POST['formule'])) ? $formule = $_POST['formule'] : $formule = "";

        /* 
        * CALCUL DES MONTANTS DE GARANTIES
        */

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

        $prime_rc = ceil(($prime + ($prime * $prime_annexe / 100)) / 365 * $pol_duration->days);

        $data['prime_rc'] = $prime_rc;

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

        $data['prime_dr'] = $prime_dr;
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

         $data['prime_ra'] = $prime_ra;
        /*
        * FIN DE CALCUL DE LA GARANTIE REMBOURSEMENT ANTICIPE
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

         $data['prime_sr'] = $prime_sr;
        /*
        * FIN DE CALCUL DE LA GARANTIE SECURITE ROUTIERE
        */

        //TOTAL PRIME POUR LE TIERS DE BASE : $prime_tb
        $prime_tb = $prime_rc + $prime_dr + $prime_ra + $prime_sr;

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

         $data['prime_bg'] = $prime_bg;
        /*
        * FIN DE CALCUL DE LA GARANTIE BRIS DE GLACE
        */

        /*
        * CALCUL DE LA GARANTIE DOMMAGES : prime_dom
        */
        $prime_dom = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['dom'])){
            $req = $bdd->prepare("SELECT prime FROM g_dom, type_g_dom WHERE `g_dom`.`type` = `type_g_dom`.`id` AND `type_g_dom`.`lib` = LOWER(?)");
            $req->execute(array($_POST['dom']));
            while ($ok = $req->fetch()) {
                $prime_dom += ceil($ok['prime'] * $prime_tb / 100);
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
        * CALCUL DE LA GARANTIE IMMOBILISATION : prime_im
        */
        $prime_im = '';
        //Récupération du paramètre dans le formulaire
        if(!empty($_POST['remb'])){
            $type_contrat = '';
            if($pol_duration_m >= 3 && $pol_duration_m < 6){
                $type_contrat = 1;
            }elseif ($pol_duration_m > 6 && $pol_duration_m < 12) {
                $type_contrat = 2;
            }elseif ($pol_duration_m >= 12) {
                $type_contrat = 3;
            }
            $req = $bdd->prepare("SELECT prime FROM g_imm WHERE contrat = ?");
            $req->execute(array($type_contrat));
            while ($ok = $req->fetch()) {
                $prime_im += $ok['prime'];
            }
            echo $pol_duration_m;
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