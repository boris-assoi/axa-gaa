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
        Information sur le véhicule
        */
        //Récupération du type de puissance fiscale
        $pf = $_POST['pf'];
        $pf_table = "ref_".$pf;
        
        //Récupération de la valeur de la puissance fiscale
        $pfValue = $_POST['pfValue'];

        //Vérification de l'existence d'une remorque        
        $rem = $_POST['rem'];

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

        //Ajout pour le statut socio-professionnel
        if ($statut_pro == "A" || $statut_pro == "B" || $statut_pro == "C") {
            $prime_annexe += (-5);
        } elseif ($statut_pro == "D" || $statut_pro == "E") {
            $prime_annexe += (-10);
        }

        $prime_rc = $prime + ($prime * $prime_annexe / 100);

        echo "Calcul de la prime pour la catégorie 1 <br>";
        echo "Prime de base : ".$prime."<br>";
        echo "Prime annexe : ".$prime_annexe."<br>";
        echo "Le montant de la prime :".$prime_rc;

    }
    catch (Exception $e)
    {
        die('Erreur:'.$e->getMessage());
    }
?> 