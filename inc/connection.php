<?php 
	$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=axa-gaa', 'axa', 'axa',$pdo_options);
?>