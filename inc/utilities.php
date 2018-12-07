<?php
    function valeurVenale($valeurCatalogue, DateTime $dateCirculation){
        $valeurVen = $valeurCatalogue;
        $dateNow = new DateTime("now", new DateTimeZone('GMT+0'));
        $dureeCirculation = $dateCirculation->diff($dateNow);
        echo '<br>Duree de circulation : '.$dureeCirculation->y.' ans';
        
            for($i = 1; $i < 8; $i++){
                    $valeurVen = $valeurVen - ceil($valeurVen * 25 / 100);
                if($i = 1){
                } 
                /*
                elseif($i = 2){
                    $valeurVen = $valeurVen - ceil($valeurVen * 20 / 100);
                } elseif($i > 2 && $i < 7){
                    $valeurVen = $valeurVen - ceil($valeurVen * 15 / 100);
                } elseif($i = 7 && $i > 7){
                    $valeurVen = $valeurVen - ceil($valeurVen * 10 / 100);
                }
                */
            }
        
        return $valeurVen;
    }
?>