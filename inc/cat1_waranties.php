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
        Informations sur le client
        */
        //Récupération de la classe d'ancienneté du permis
        $classe_permis = $_POST['classe_permis'];

        //Récupération du statut socio-professionnel
        $statut_pro = $_POST['status-pro'];

        /*
        * Informations sur la police
        */
        //Récupération de la date de début d'effet
        (!empty($_POST['poldf'])) ? $rem = date($_POST['poldf']):$poldf = '';

        //Récupération de la date de fin d'effet
        (!empty($_POST['poldt'])) ? $rem = date($_POST['poldt']):$poldt = '';

        //Calcul de la durée de la police
        $pol_duration = $poldt - $poldf;
        
        /*
        Information sur le véhicule
        */
        //Récupération du type de puissance fiscale
        $pf = $_POST['pf'];
        $pf_table = "ref_".$pf;
        
        //Récupération de la valeur de la puissance fiscale
        $pfValue = $_POST['pfValue'];

        //Vérification de l'existence d'une remorque        
        (!empty($_POST['rem'])) ? $rem = $_POST['rem']:$rem = '';

        /*
        *CALCUL DE LA GARANTIE RESPONSABILITE CIVILE
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

        echo "Calcul de la prime pour la garantie de la responsabilité civile <br>";
        echo "Prime de base : ".$prime."<br>";
        echo "Prime annexe : ".$prime_annexe."<br>";
        echo "Le montant de la prime :".$prime_rc;

        /*
        * FIN DE CALCUL DE LA GARANTIE DE LA RESPONSABILITE CIVILE
        */

        /*
        * CALCUL DE LA GARANTIE DEFENSE ET RECOURS
        */
        

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 