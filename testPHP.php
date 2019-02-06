<?php
    try
    {
        session_start();

        include_once "inc/acl.php";

        /*
        if (!in_array($_SESSION['type'], $acl_mod_com)) {
            header("location: accesDenied.php");
        }
        */

        include_once "inc/connection.php";
        include_once "inc/models.php"; 


        /* 
        * INFORMATIONS SUR L'ATTESTATION
        */
        //Recupération du type d'attestation
        (!empty($_POST['typAtt'])) ? $typAtt = $_POST['typAtt'] : $typAtt = "automobile";        

        /*
        * INFORMATIONS SUR LE CLIENT
        */
        //Recupération du type de client
        (!empty($_POST['typeClient'])) ? $typeClient = $_POST['typeClient'] : $typeClient = "";
        
        //Recupération du nom du client
        (!empty($_POST['nomClient'])) ? $nomClient = $_POST['nomClient'] : $nomClient = "Assoi";

        //Recupération de la classe d'ancienneté du permis de conduire du client
        (!empty($_POST['classe_permis'])) ? $classe_permis = $_POST['classe_permis'] : $classe_permis = "classe 1";

        //Recupération du statut socio-professionnel du client
        (!empty($_POST['statut_pro'])) ? $statut_pro = $_POST['statut_pro'] : $statut_pro = "a";

        //Recupération de la profession du client
        (!empty($_POST['pro'])) ? $pro = $_POST['pro'] : $pro = "Developpeur";

        //Recupération de l'adresse du client
        (!empty($_POST['adresse'])) ? $adresse = $_POST['adresse'] : $adresse = "Abidjan";

        //Recupération du contact du client
        (!empty($_POST['contact'])) ? $contact = $_POST['contact'] : $contact = "08080808";

        /*
        * INFORMATIONS SUR LA POLICE
        */
        //Recupération du numéro de police
        (!empty($_POST['pol'])) ? $pol = $_POST['pol'] : $pol = "16251626AZ";

        //Récupération de la date de début d'effet
        (!empty($_POST['poldf'])) ? $poldf = new DateTime($_POST['poldf'], new DateTimeZone('GMT+0')) : $poldf = new DateTime('01/01/2019', new DateTimeZone('GMT+0'));

        //Récupération de la date de fin d'effet
        (!empty($_POST['poldt'])) ? $poldt = DateTime::createFromFormat('M/j/Y', $_POST['poldt'], new DateTimeZone('GMT+0')) : $poldt = new DateTime('01/02/2020', new DateTimeZone('GMT+0'));

		//Récupération de la durée de la police
		//$poldt->add(new DateInterval('PT1'));
        (!empty($_POST['poltime'])) ? $poltime = DateInterval::createFromDateString($_POST['poltime']. 'days')  : $poltime = ($poldf->diff($poldt));
        
        //Valeur de retour test
        $data['poltime'] = $poltime;
        $data['poldt'] = $poldt;
        $data['poldf'] = $poldf;


        /*
        * INFORMATIONS SUR LE VEHICULE
        */
        //Recupération de la catégorie du véhicule
        (!empty($_POST['catCar'])) ? $catCar = $_POST['catCar'] : $catCar = "1";

        //Recupération du genre
        (!empty($_POST['carGenre'])) ? $carGenre = $_POST['carGenre'] : $carGenre = "BERLINE";

        //Recupération de la marque
        (!empty($_POST['carMake'])) ? $carMake = $_POST['carMake'] : $carMake = "MERCEDES";

        //Recupération du numéro d'immatriculation
        (!empty($_POST['imat'])) ? $imat = $_POST['imat'] : $imat = "2121OZ01";

        //Recupération de la date de mise en circulation
        (!empty($_POST['dateCirc'])) ? $dateCirc = $_POST['dateCirc'] : $dateCirc = "01/01/2015";

        //Recupération de la puissance fiscale
        (!empty($_POST['pf'])) ? $pf = $_POST['pf'] : $pf = "diesel";
        $pf_table = "ref_".$pf;
        
        //Recupération de la valeur de la puissance fiscale
        (!empty($_POST['pfValue'])) ? $pfValue = $_POST['pfValue'] : $pfValue = "3";

        //Recupération de la valeur catalogue
        (!empty($_POST['valCat'])) ? $valCat = $_POST['valCat'] : $valCat = "11000000";

        //Recupération de la valeur vénale
        (!empty($_POST['valVen'])) ? $valVen = $_POST['valVen'] : $valVen = "4768500";

        //Vérification de l'existence d'une remorque        
        (!empty($_POST['rem'])) ? $rem = $_POST['rem'] : $rem = '';

        /* 
        * INFORMATIONS SUR LA FORMULE DE GARANTIES
        */
        //Récupération de la formule sélectionnée
		(!empty($_POST['formule'])) ? $formule = $_POST['formule'] : $formule = "";
		
		/*
		* INFORMATIONS SUR LES GARANTIES A AJOUTER
		*/
		//Récupération du type de garantie DEFENSE ET RECOURS
		(!empty($_POST['defense'])) ? $defense = 1 : $defense = 2;

		//Récupération de l'option de la garantie SECURITE ROUTIERE
		(!empty($_POST['sec_route'])) ? $sec_route = $_POST['sec_route'] : $sec_route = 2;

		//Récupération du type de garantie DOMMAGES
		(!empty($_POST['dom'])) ? $dom = $_POST['dom'] : $dom = 2;

		//Récupération de l'option de la garantie BRIS DE GLACE
		(!empty($_POST['bris'])) ? $bris = $_POST['bris'] : $bris = "reparateur non conventionne";

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
        
        //Recupération du label
        $pfLib = "";
        if($pf == "Diesel") {
            if($pfValue == 1){
                $pfLib = "a";
            } elseif($pfValue >= 2 && $pfValue < 5) {
                $pfLib = "b";
            } elseif($pfValue >= 5 && $pfValue < 7) {
                $pfLib = "c";
            } elseif($pfValue >= 7 && $pfValue < 9) {
                $pfLib = "d";
            } elseif($pfValue >= 9) {
                $pfLib = "e";
            }
        } elseif($pf == "Essence"){
            if($pfValue >= 1 && $pfValue < 3){
                $pfLib = "a";
            } elseif($pfValue >= 3 && $pfValue < 7) {
                $pfLib = "b";
            } elseif($pfValue >= 7 && $pfValue < 10) {
                $pfLib = "c";
            } elseif($pfValue >= 10 && $pfValue < 12) {
                $pfLib = "d";
            } elseif($pfValue >= 12) {
                $pfLib = "e";
            }
        }

        $data['pfValue'] = $pfValue;
        $data['pf'] = $pf;
        $data['pfLib'] = $pfLib;
        $data['nomClient'] = $nomClient;

		$request = "SELECT zone1 AS prime FROM prime_rc_cat1, ".$pf_table." WHERE es = ".$pf_table.".id AND ".$pf_table.".lib = ?";
        $req = $bdd->prepare($request);
        $req->execute(array($pfLib));
        while ($ok = $req->fetch()) {
            $prime = $ok['prime'];
		}
        $req->closeCursor();

        //Ajout pour la remorque
        if (!empty($rem)) {
            $prime = $prime + ($prime * 10 / 100);
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

        $prime_rc = ceil(($prime + ($prime * $prime_annexe / 100)) / 365 * $poltime->d);
        $data['prime'] = $prime;
        $data['prime_annexe'] = $prime_annexe;

		$data['prime_rc'] = $prime_rc;
		
		// echo "Prime RC : ".$data['prime_rc']."<br>";

        /*
        * FIN DE CALCUL DE LA GARANTIE DE LA RESPONSABILITE CIVILE
        */

        /*
        * CALCUL DE LA GARANTIE DEFENSE ET RECOURS : prime_dr
        */
        $prime_dr = '';
        
        //Récupération du forfait
        $req = $bdd->prepare("SELECT prime FROM g_def_rec WHERE type_garantie = ?");
		$req->execute(array($defense));
		while ($ok = $req->fetch()) {
			$prime_dr += $ok['prime'];
		}
		$req->closeCursor();

        $data['prime_dr'] = $prime_dr;
		// echo "Prime DR : ".$data['prime_dr']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE DEFENSE ET RECOURS
        */

        /*
        * CALCUL DE LA GARANTIE REMBOURSEMENT ANTICIPE : prime_ra
        */
		$prime_ra = '';
        $type_prime_ra = '';
        
		//Détermination du type de prime
		if ($poltime->d == 365) {
			$type_prime_ra = 2;
		} else {
			$type_prime_ra = 1;
        }
        
        //Récupération du paramètre dans le formulaire
        $req = $bdd->prepare("SELECT prime FROM g_rem_ant WHERE type_prime = ?");
		$req->execute(array($type_prime_ra));
		while ($ok = $req->fetch()) {
			$prime_ra += $ok['prime'];
		}
		$req->closeCursor();

        $data['prime_ra'] = $prime_ra;
		// echo "Prime RA : ".$data['prime_ra']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE REMBOURSEMENT ANTICIPE
        */

        /*
        * CALCUL DE LA GARANTIE SECURITE ROUTIERE : prime_sr
        */
        $prime_sr = '';
        
        //Récupération du paramètre dans le formulaire
        $req = $bdd->prepare("SELECT prime FROM option_g_sec_rou WHERE id = ?");
		$req->execute(array($sec_route));
		while ($ok = $req->fetch()) {
			$prime_sr += $ok['prime'];
		}
		$req->closeCursor();

		$prime_sr = ceil($prime_sr * $poltime->d / 365);

        $data['prime_sr'] = $prime_sr;
		// echo "Prime SR : ".$data['prime_sr']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE SECURITE ROUTIERE
        */

        /* 
        * TOTAL PRIME POUR LE TIERS DE BASE : $prime_tb 
        */
        $prime_tb = $prime_rc + $prime_dr + $prime_ra + $prime_sr;

        /*
        * CALCUL DE LA GARANTIE BRIS DE GLACE : prime_bg
        */
        $prime_bg = '';
        //Récupération du paramètre dans le formulaire
        $req = $bdd->prepare("SELECT prime FROM g_bri_gla, option_g_bri_gla WHERE `g_bri_gla`.`option` = `option_g_bri_gla`.`id` AND `option_g_bri_gla`.`lib` = LOWER(?)");
		$req->execute(array($bris));
		while ($ok = $req->fetch()) {
			$prime_bg += $ok['prime'] * $valCat / 100;
		}
		$req->closeCursor();

         $data['prime_bg'] = $prime_bg;
		// echo "Prime BG : ".$data['prime_bg']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE BRIS DE GLACE
        */

        /*
        * CALCUL DE LA GARANTIE DOMMAGES : prime_dom
        */
        $prime_dom = '';
        //Récupération du paramètre dans le formulaire
        $req = $bdd->prepare("SELECT prime FROM g_dom WHERE g_dom.type = ?");
		$req->execute(array($dom));
		while ($ok = $req->fetch()) {
			$prime_dom += ceil($ok['prime'] * $prime_tb / 100);
		}
		$req->closeCursor();

        $data['prime_dom'] = $prime_dom;
		// echo "Prime DOM : ".$data['prime_dom']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE DOMMAGES
        */

        /* 
        * CALCUL DE LA GARANTIE VOL A MAIN ARMEE
        */
        $prime_vol_ma = '';
        $req = $bdd->query("SELECT seuil, taux_moins, taux_plus FROM g_vol");
        while ($ok = $req->fetch()) {
            if($valVen < $ok['seuil']) {
                $prime_vol_ma = $prime_tb * $ok['taux_moins'] / 100;
            } elseif ($valVen > $ok['seuil']) {
                $prime_vol_ma = $prime_tb * $ok['taux_plus'] / 100;
            }
        }
        $req->closeCursor();

		$data['prime_vol_ma'] = ceil($prime_vol_ma);
		
		// echo "Prime VOL MA : ".$data['prime_vol_ma']."<br>";

        /* 
        * FIN DE CALCUL DE LA GARANTIE VOL A MAIN ARMEE
        */

        /*
        * CALCUL DE LA GARANTIE VANDALISME : prime_van
        */
        $prime_van = '';
        //Récupération du paramètre dans le formulaire
        $req = $bdd->query("SELECT forfait FROM g_van");
        while ($ok = $req->fetch()) {
            $prime_van += $ok['forfait'];
        }
        $req->closeCursor();        

        $data['prime_van'] = $prime_van;
		// echo "Prime VAN : ".$data['prime_van']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE VANDALISME
        */

        /* 
        * CALCUL DE LA GARANTIE INCENDIE
        */
        $prime_inc = '';
        $req = $bdd->query("SELECT seuil, taux_moins, taux_plus FROM g_inc");
        while ($ok = $req->fetch()) {
            if($valVen < $ok['seuil']) {
                $prime_inc = $prime_tb * $ok['taux_moins'] / 100;
            } elseif ($valVen > $ok['seuil']) {
                $prime_inc = $prime_tb * $ok['taux_plus'] / 100;
            }
        }
        $req->closeCursor();

        $data['prime_inc'] = $prime_inc;
		// echo "Prime INC : ".$data['prime_inc']."<br>";
        /* 
        * FIN DU CALCUL DE LA GARANTIE INCENDIE
        */

        /*
        * CALCUL DE LA GARANTIE IMMOBILISATION : prime_im
        */
        $prime_im = '';

        //Récupération du paramètre dans le formulaire
        $type_contrat = '';

		if(($poltime->d / 30) >= 3 && ($poltime->d / 30) < 6){
			$type_contrat = 1;
		}elseif (($poltime->d / 30) >= 6 && ($poltime->d / 30) < 12) {
			$type_contrat = 2;
		}elseif (($poltime->d / 30) >= 12) {
			$type_contrat = 3;
		}
		$req = $bdd->prepare("SELECT prime FROM g_imm WHERE contrat = ?");
		$req->execute(array($type_contrat));
		while ($ok = $req->fetch()) {
			$prime_im += $ok['prime'];
		}
		// echo $poltime->days;
        $req->closeCursor();
        
        $data['type_contrat_im'] = $type_contrat;
        $data['prime_im'] = $prime_im;
		// echo "Prime IM : ".$data['prime_im']."<br>";
        /*
        * FIN DE CALCUL DE LA GARANTIE IMMOBILISATION
        */

        /* RETOUR DU JSON A LA REQUETE AJAX */
        echo json_encode($data);

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 