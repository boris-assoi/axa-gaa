<?php
    include_once "utilities.php";

    $valCat = 4000000;
    $datecirculation = new DateTime("10/01/2010");
    $valven = valeurVenale($valCat, $datecirculation);

    echo 'Valeur catalogue : '.$valCat;
    echo '<br>Année de mise en circulation : '.$datecirculation->format('d/m/Y');
    echo '<br>Valeur vénale : '.$valven;
?>